<?php

namespace System;

abstract class Controller
{
    function __construct() {
        $this->system = Initiate::getInstance();
        $this->input = new Input();
    }
    
    function get()
    {
        
    }
    
    function update()
    {
        
    }
    
    function create()
    {
        
    }
    
    function delete()
    {
        
    }
}