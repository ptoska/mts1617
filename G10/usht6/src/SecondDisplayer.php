<?php

class SecondDisplayer implements Displayer {
    
    public function display($array)
    {

        echo("Displaying with second displayer <br />\n");
        echo implode("----", $array)."<br />\n";
    }
}