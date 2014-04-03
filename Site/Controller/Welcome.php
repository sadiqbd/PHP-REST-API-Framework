<?php

namespace Site\Controller;

class welcome extends \System\Controller
{
    function __construct() {
        parent::__construct();
    }
    
    function index()
    {
        var_dump($this->system);
        $input = file_get_contents('php://input');
            echo $input;
        
        var_dump($_GET);
        echo $p1;
        echo $p2;
        echo "Test";
    }
}
    