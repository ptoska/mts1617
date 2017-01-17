<?php

class FirstDisplayer implements Displayer {
    
    public function display($array)
    {
        echo("Displaying with first displayer <br />\n");
        foreach ($array as $row)
        {
            echo $row . "<br />\n";
        }
    }
    
}