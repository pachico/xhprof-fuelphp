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
Autoloader::add_core_namespace('Xhprof');

Autoloader::add_classes(array(
	'Xhprof\\Xhprof' => __DIR__ . '/classes/xhprof.php',
	'Xhprof\\Model_Run' => __DIR__ . '/classes/model/run.php',
));