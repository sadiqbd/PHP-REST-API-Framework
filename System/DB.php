<?php

namespace System;

class DB
{
    function __construct() {
        echo getConfig("db_server");
    }
}