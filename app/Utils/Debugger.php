<?php

namespace App\Utils;

class Debugger
{

    public static function debug($variables = array())
    {
        foreach ($variables as $variable) {
            echo "<pre>";
            echo "<h4>Target Variable: " . gettype($variable) . "</h4>";
            print_r($variable);
            echo "<br><br><hr>";
            echo "</pre>";
        }
    }

    public static function debugAll($variables = array())
    {
        echo "<pre>";
        echo "<h4>SERVER</h4>";
        print_r($_SERVER);
        echo "<br>";
        echo "<h4>REQUEST</h4>";
        print_r($_REQUEST);
        echo "<br>";
        echo "</pre>";
        foreach ($variables as $variable) {
            echo "<pre>";
            echo "<h4>Target Variable: " . gettype($variable) . "</h4>";
            print_r($variable);
            echo "<br><br>";
            echo "</pre>";
        }
    }
}
