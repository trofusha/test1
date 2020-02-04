<?php
declare(strict_types=1);

trait PPrint {
    
    public function PrinParsetLog(int $Row) {
        echo "String is $Row ".'Time is...'.date('H:i:s',time()).' memory usage is '.$this->formatBytes(memory_get_peak_usage()).PHP_EOL;
    }
    
    public function formatBytes($bytes, $precision = 2) {

        $units = array("b", "kb", "mb", "gb", "tb");
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));
        return round($bytes, $precision) . " " . $units[$pow];
    }

}
