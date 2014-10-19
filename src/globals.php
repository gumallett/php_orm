<?php

function __autoload($class) {
   file_put_contents("php://stderr", 'Loading class: '.$class."\n");
   require_once $class . '.php';
}