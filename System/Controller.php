<?php

namespace System;

abstract class Controller
{
    function __construct() {
        $this->system = Initiate::getInstance();
        $this->input = new Input();
    }
}