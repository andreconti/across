<?php

define('BASE_PATH', realpath(dirname(__FILE__) . '/../'));

function AppAutoloader($class){
	
	$filename = BASE_PATH . '/controllers/' . str_replace('\\', '/', $class) . '.php';
	
	if (file_exists($filename))
		require_once $filename;
}
spl_autoload_register('AppAutoloader');