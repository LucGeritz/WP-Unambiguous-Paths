<?php
/*
Plugin Name: Unambiguous Paths
Plugin URI: https://github.com/LucGeritz/WP-Unambiguous-Paths
Description: Refer in an unambiguous way to paths and uris.
Version: 0.1
Author: Luc Geritz / Tigrez Software
*/
spl_autoload_register( 
	
	function ($class) {

		$base_dir = str_replace('\\','/',trailingslashit(dirname(__FILE__)));
		$base_namespace = 'Tigrez'; // <== veranderen bij hergebruik voor andere plugin

		if(strpos($class,$base_namespace)!==0) return; // not my class
		$class = trim(str_replace($base_namespace, '',$class),'\\');
		$file=$base_dir.$class.'.php';
		$file=str_replace('\\','/',$file);
		if(!file_exists($file)) return;
		require($file);
	}	

);
