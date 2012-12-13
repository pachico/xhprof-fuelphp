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
	/**
	 * Possible profiling modes are:
	 * \Xhprof\Xhprof::XHPROF_PROFILE_ALWAYS
	 * \Xhprof\Xhprof::XHPROF_PROFILE_ON_DEMAND
	 * \Xhprof\Xhprof::XHPROF_PROFILE_NEVER
	 */
	'profile_on' => \Xhprof\Xhprof::XHPROF_PROFILE_ALWAYS,
	/**
	 * Allowed flags are:
	 * XHPROF_FLAGS_CPU: Profiles CPU time
	 * XHPROF_FLAGS_MEMORY: Profiles memory usage
	 * XHPROF_FLAGS_NO_BUILTINS: Doesn't profile built in functions
	 */
	'flags' => XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY,
	/**
	 * If set to null XHPROF will start profiling right after bootstrap.
	 * Alternatively any event step can be specified. Allowed steps are:
	 * http://fuelphp.com/docs/classes/event.html
	 * Make sure start event comes before end event
	 */
	'start_profiling_event' => 'controller_finished',
	/**
	 * If set to null XHPROF will stop profiling at shutdown event.
	 * Alternatively any event step can be specified. Allowed steps are:
	 * http://fuelphp.com/docs/classes/event.html
	 * Make sure start event comes before end event
	 */
	'end_profiling_event' => null,
	/**
	 * On demand profiling requires to store a cookie.
	 * This is the name the cookie will have
	 */
	'cookie_name' => 'XHPROF_FUELPHP',
	/**
	 * On demand profiling is triggered by a parameter sent via get
	 */
	'get_parameter_activation' => '_profile',
	/**
	 * Array of function names that will be ignored during profile data collection
	 */
	'ignored_functions' => array(
		'call_user_func',
		'call_user_func_array'),
	/**
	 * Most likely Fuel will take care of your 404, which means xhprof will
	 * try to profile the 404 response page for assets that might not exist.
	 * To avoid this, you can disable requests to be profiled by file extension
	 */
	'ignored_extensions' => array(
		'png', 'gif', 'jpg', 'jpeg', 'ico', 'js', 'css'
	)
);
