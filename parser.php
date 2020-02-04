<?php
require_once 'vendor/autoload.php';

//include 'classes/Print.trait.php';
//include 'classes/Parser.class.php';
//include 'classes/DB.class.php';


$pathToConfig=$argv[1];
$pathToFile=$argv[2];



echo 'start...'.PHP_EOL;
echo 'StartTime is...'.date('H:i:s',time()).PHP_EOL;
print ('Read config...');
if (!file_exists($pathToConfig)){die("Use correct config fileneme after command e.g.:'$ parser.php config.json data/dataset.csv'");}
$BDData= json_decode(file_get_contents($pathToConfig));
print ('Create Parser object...');
$parser = new Parser($pathToFile, $BDData, $BDData->BDType);
print ('success.'.PHP_EOL);
$parser->start_timestamp= time();
print ('BD Init...');
if(!$parser->InitBD()){die ('DB Connect Error'.PHP_EOL);}
print ('success.'.PHP_EOL);
print ('Create Table...');
if(!$parser->BD->TableIsset()){
    print ('Table exists'.PHP_EOL);
}else{
    if(!$parser->BD->CreateTable()){die ('Create Table Error'.PHP_EOL);}
}
print ('success.'.PHP_EOL);
print ('Check file...');
if(!$parser->FileIsset()){die ("Datafile not exists! Use correct datafile fileneme after config filename e.g.:'$ parser.php config.json data/dataset.csv'".PHP_EOL);}
print ('success.'.PHP_EOL);
print ('Start file parsing...'.PHP_EOL);
if(!$parser->FileIterate()){('Error during parsing!'.PHP_EOL);}
print ('success.'.PHP_EOL);
echo 'FinishTime is...'.date('H:i:s',time()).PHP_EOL;
$parser->finish_timestamp= time();
$time=$parser->finish_timestamp - $parser->start_timestamp;

echo 'Time to run is '.$time.' seconds. Memory peak is '.$parser->formatBytes(memory_get_peak_usage()).PHP_EOL;



