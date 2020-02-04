<?php
declare(strict_types=1);

interface IBD {
    public function __Construct($BDData);
    public function ConnectBD (): bool;
    public function CreateTable(): bool;  
    public function Insert(string $query):bool;
    public function ConstructSQL(array $record) : string;

    
}

class BDMysql implements IBD {
    
    public $connection;
    public $BDData;
    public function __Construct($BDData) {
        $this->BDData=$BDData;
       
    }
   
    public function ConnectBD(): bool {
        
        if($obj= new mysqli($this->BDData->host, $this->BDData->user,$this->BDData->pass, $this->BDData->BDName)){
            $obj->set_charset($this->BDData->charset);
            
            $this->connection=$obj;
            return true;
        }
        return false;
        
    }
    public function TableIsset(): bool {
        if ($result = $this->connection->query("SHOW TABLES LIKE '" . $this->BDData->tableName . "';")) {

            if ($result->num_rows !== 1) {
                return true;
            }
        }
        return false;
    }

    public function CreateTable(): bool {


        $fields = array_combine($this->BDData->fields, $this->BDData->fieldsType);
        $query = "CREATE TABLE `" . $this->BDData->BDName . "`.`" . $this->BDData->ableName . "` (";
        foreach ($fields as $name => $type) {
            $query .= " `$name` $type ,";
        }
        $query .= " PRIMARY KEY (`" . $this->BDData->PKey . "`));";
        if ($result = $this->connection->query($query)) {
            return true;
        }

        return false;
    }


    public function ConstructSQL(array $record): string {
         $query="INSERT IGNORE INTO `".$this->BDData->tableName."` (";
        foreach ($this->BDData->fields as $fieldName) {
            $query.="`$fieldName`, ";
        }
        $query= substr($query, 0,-2);
        $query.= ") VALUES ("; 
        foreach ($record as $value) {
            $query.="'$value', ";
        }
        $query= substr($query, 0,-2);
        $query.=");";
        return $query;
    }
    public function Insert($query):bool {
 
        if ($result = $this->connection->query($query)){
    
            return true;
        }

        return false;
    }




}

