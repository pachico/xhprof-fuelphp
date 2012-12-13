<?php

/**
 * Xhprof-FuelPHP is a package to profile FuelPHP applications using
 * Xhprof profiler
 *
 * @package    Xhprof-FuelPHP
 * @version    1.0
 * @author     Mariano F.co Benítez Mulet 
 * @license    MIT License
 * @copyright  2012 - 2013 Mariano F.co Benítez Mulet 
 * @link       https://github.com/pachico/xhprof-fuelphp
 */
return array(
	'xhprof' => array(
		'type' => 'mysqli',
		'connection' => array(
			'hostname' => 'localhost',
			'port' => '3306',
			'database' => 'xhprof',
			'username' => 'xhprof',
			'password' => 'xhprof',
			'persistent' => false,
			'compress' => false,
		),
		'identifier' => '`',
		'table_prefix' => '',
		'charset' => 'utf8',
		'enable_cache' => true,
		'profiling' => false,
	)
);

