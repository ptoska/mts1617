<?php

require 'vendor/autoload.php';

$c = new Container();
$inst = new SaveInstance();
$inst->startMonitoringInstance();
$arr = array(array("interface"=>"MovieFinder","class"=>array("TextMovieFinder","JsonMovieFinder")),
			array("interface"=>"Displayer","class"=>array("FirstDisplayer","SecondDisplayer")));
$c->addImpl($arr);

for ($i=0; $i < 3; $i++) { 
	$ml = $c->getInstance("MovieLister",2);

	$ml->test();
}