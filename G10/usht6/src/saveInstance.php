<?php
	/**
	* Kjo klase ruan instancat per secilin implementin te interfaceve
	*/
	class SaveInstance 
	{
	
		function startMonitoringInstance(){
			$fp = fopen(__DIR__ . '/../data/instance.json', 'w');
			$instance = array('MovieFinder' =>array("TextMovieFinder"=>0,"JsonMovieFinder"=>0) ,'Displayer' =>array("FirstDisplayer"=>0,"SecondDisplayer"=>0) );
			fwrite($fp, json_encode($instance));
			fclose($fp);
		}
		function saveStatus($instance){
			$fp = fopen(__DIR__ . '/../data/instance.json', 'w');
			fwrite($fp, json_encode($instance));
			fclose($fp);
		}
		function getInstancesStatus(){
			return json_decode(file_get_contents(__DIR__ . "/../data/instance.json"));
		}
	}
?>