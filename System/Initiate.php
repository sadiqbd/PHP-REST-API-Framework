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

        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
        $handler = explode("/", $_GET[getConfig('route_handler')]);
        unset($_GET[getConfig('route_handler')]);

        if (getConfig('use_module') == true) {
            if (isset($handler[0]) && !empty($handler[0])) {
                $this->module = $handler[0];
                unset($handler[0]);
                $handler = array_values($handler);
            }
            else
                $this->module = getConfig('default_module');
        }
        else
            $this->module = getConfig('default_module');


        if (isset($handler[0]) && !empty($handler[0])) {
            $this->controller = $handler[0];
            unset($handler[0]);
            $handler = array_values($handler);
        }
        else
            $this->controller = getConfig('default_controller');

        if (isset($handler[0]) && !empty($handler[0])) {
            $this->action = $handler[0];
            unset($handler[0]);
            $handler = array_values($handler);
        }
        else
            $this->action = getConfig('default_action');

        if (isset($handler[0]) && !empty($handler[0])) {
            $this->params = $handler;
            unset($handler);
        }
        else
            $this->params = array();
    }

    function loadDB() {
        $this->DB = new \System\DB();
    }

    function start() {
        $this->parseHandler();
        $classToLoad = "\\" . ucfirst($this->module) . "\\Controller\\" . ucfirst($this->controller);
        $controller = new $classToLoad();
        $functionToCall = $this->action;
        if (empty($this->params)) {
            if (method_exists($controller, $functionToCall)) {
                $controller->$functionToCall();
            } else {
                array_unshift($this->params, $functionToCall);
                $this->processDefaultActoin($controller, $this->params);
            }
        } else {

            if (method_exists($controller, $functionToCall)) {
                call_user_func_array(array($controller, $functionToCall), $this->params);
            } else {
                array_unshift($this->params, $functionToCall);
                $this->processDefaultActoin($controller, $this->params);
            }
        }
    }
    
    function processDefaultActoin(&$controller, $params = array())
    {
        switch ($this->method) {
            case "put":
                call_user_func_array(array($controller, getConfig('default_put_action')), $this->params);
                break;
            case "post":
                call_user_func_array(array($controller, getConfig('default_post_action')), $this->params);
                break;
            case "delete":
                call_user_func_array(array($controller, getConfig('default_delete_action')), $this->params);
                break;
            case "get":
                call_user_func_array(array($controller, getConfig('default_get_action')), $this->params);
                break;
            default:
                break;
        }
    }

}