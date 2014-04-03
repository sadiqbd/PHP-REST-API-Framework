<?php

namespace System;

class Input {

    function __construct() {
        $this->system = Initiate::getInstance();
    }

    function get() {
        return $_GET;
    }

    function post() {
        return $_POST;
    }

    function rawPost() {
        return file_get_contents('php://input');
    }

    function put() {
        return parse_str(file_get_contents('php://input'));
    }

    function rawPut() {
        return file_get_contents('php://input');
    }

    function delete() {
        return parse_str(file_get_contents('php://input'));
    }

    function rawDelete() {
        return file_get_contents('php://input');
    }

}