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

        var_dump(getallheaders());
        echo $p1;
        echo $p2;
        echo "Test";
    }
    
    function get($id = "")
            
    {
        if(empty($id))
            echo "All get";
        else 
            echo $id." get";
    }
    
    function delete($id) {
        echo $id." deleted";
    }
}
    