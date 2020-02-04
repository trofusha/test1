<?php

declare(strict_types=1);

interface Iparser {

    public function __Construct(string $PathToFile, object $BDData, string $BDType);

    public function FileRead();

    public function FileIsset(): bool;

    public function FileIterate(): bool;

    public function InitBD(): bool;
}

Class Parser implements Iparser {

    use PPrint;

    public $PathToFile;
    public $Record;
    public $BDData;
    public $BDType;
    public $BD;
    private $Iterator;
    public $resource;
    public $start_timestamp;
    public $finish_timestamp;
    static public $RowsReaded = 0;

    public function __Construct(string $PathToFile, object $BDData, string $BDType) {

        $this->PathToFile = $PathToFile;
        $this->BDData = $BDData;
        $this->BDType = $BDType;
    }

    public function FileIsset(): bool {
        if (file_exists($this->PathToFile)) {
            $this->resource = fopen($this->PathToFile, "r");
            $this->Iterator = $this->FileRead();
            return true;
        }
        return false;
    }

    public function FileRead() {
        while (!feof($this->resource)) {
            if ($res = fgets($this->resource)) {
                yield trim($res);
            }
        }
        fclose($this->resource);
    }

    public function FileIterate(): bool {
        $this->BD->connection->autocommit(FALSE);

        foreach ($this->Iterator as $iteration) {
            $this->Record = str_getcsv($iteration, ' ');
            $query = $this->BD->ConstructSQL($this->Record);
            $this->BD->Insert($query);
            self::$RowsReaded++;
            if ((self::$RowsReaded % 1000) === 0 && self::$RowsReaded !== 0) {
                $this->BD->connection->commit();
                
                $this->PrinParsetLog(self::$RowsReaded);
            }
        }
        $this->PrinParsetLog(self::$RowsReaded);
        return true;
    }

    public function InitBD(): bool {
        if (!class_exists($this->BDType)) {
            print ('Wrond BD Type.' . PHP_EOL);
            return false;
        }
        $this->BD = New $this->BDType($this->BDData);
        if ($this->BD->ConnectBD()) {
            return true;
        }
        return false;
    }

}
