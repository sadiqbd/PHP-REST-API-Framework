<?php

namespace System;

class Initiate {

    static $instance = null;
    var $module;
    var $controller;
    var $action;
    var $method;
    var $params = array();

    private function __construct() {
        
    }

    public static function getInstance() {
        if (Initiate::$instance === null) {
            Initiate::$instance = new Initiate();
        }

        return Initiate::$instance;
    }

    function parseHandler() {
        
        $this->method = $_SERVER['REQUEST_METHOD'];
        $handler = explode("/", $_GET[getConfig('route_handler')]);
        unset($_GET[getConfig('route_handler')]);

        if (getConfig('use_module') == true) {
            if (isset($handler[0]) && !empty($handler[0])) {
                $this->module = $handler[0];
                unset($handler[0]);
                $handler = array_values($handler);
            }else
                $this->module = getConfig('default_module');
        }else
            $this->module = getConfig('default_module');


        if (isset($handler[0]) && !empty($handler[0])) {
            $this->controller = $handler[0];
            unset($handler[0]);
            $handler = array_values($handler);
        }else
            $this->controller = getConfig('default_controller');

        if (isset($handler[0]) && !empty($handler[0])) {
            $this->action = $handler[0];
            unset($handler[0]);
            $handler = array_values($handler);
        }else
            $this->action = getConfig('default_action');

        if (isset($handler[0]) && !empty($handler[0])) {
            $this->params = $handler;
            unset($handler);
        }else
            $this->params = array();
    }

    function loadDB() {
        $this->DB = new \System\DB();
    }
    
    function start()
    {
        $this->parseHandler();
        $classToLoad = "\\".ucfirst($this->module)."\\Controller\\".ucfirst($this->controller);
        $controller = new $classToLoad();
        $functionToCall = $this->action;
        if(empty($this->params))
        {
            $controller->$functionToCall();
        }else{
            call_user_func_array(array($controller,$functionToCall),$this->params);
        }
        
    }
}