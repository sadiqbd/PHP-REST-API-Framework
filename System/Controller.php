<?php

namespace System;

abstract class Controller
{
    function __construct() {
        $this->system = \System\Initiate::getInstance();
    }
}