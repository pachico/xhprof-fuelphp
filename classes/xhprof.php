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

namespace Xhprof;

class Xhprof
{
	/**
	 * Always profile
	 */

	const XHPROF_PROFILE_ALWAYS = 2;

	/**
	 * Only profile if requested via url, therefore set in cookie
	 */
	const XHPROF_PROFILE_ON_DEMAND = 1;

	/**
	 * Never profile
	 */
	const XHPROF_PROFILE_NEVER = 0;

	/**
	 * Flag that determines if app run can be profiled
	 * @var bool 
	 */
	protected static $_is_profilable = false;

	/**
	 *
	 * @var \Xhprof\Engine
	 */
	protected static $_profiler = null;

	/**
	 * Method called automatically from fuel.
	 * I'll check if it's possible even to profile
	 */
	public static function _init()
	{
		\Config::load('xhprof', true);

		self::set_profilable(self::check_if_profilable());

	}

	/**
	 * Checks if possible to profile at all depending on modes and configs
	 * @return boolean 
	 * @todo Not good that the same method returns true/false but also
	 * redirects/refreshes requests. Need a more elegant approach
	 */
	public static function check_if_profilable()
	{
		/**
		 * Makes sure nothing happens if xhprof extension isn't intalled
		 */
		if (function_exists('xhprof_enable') === false)
		{
			goto end_function_ko;
		}

		/**
		 * Checking for extensions that should not be profiled. This avoids 
		 * also profiling 404 responses of missing assets
		 */
		if (strripos(\Input::server('REQUEST_URI'), '.') !== false)
		{
			$position_last_dot = strripos(\Input::server('REQUEST_URI'), '.');
			$extension = ltrim(substr(\Input::server('REQUEST_URI'), $position_last_dot), '.');

			if (in_array($extension, \Config::get('xhprof.ignored_extensions', array())))
			{
				goto end_function_ko;
			}
		}

		/**
		 * If profiler is set to never profile or hasn't been set, just don't profile
		 */
		if (\Config::get('xhprof.profile_on', Xhprof::XHPROF_PROFILE_NEVER) === Xhprof::XHPROF_PROFILE_NEVER)
		{
			goto end_function_ko;
		}

		/**
		 * If profiler is set to never profile or hasn't been set, just don't profile
		 */
		if (\Config::get('xhprof.profile_on', Xhprof::XHPROF_PROFILE_NEVER) === Xhprof::XHPROF_PROFILE_ALWAYS)
		{
			goto end_function_ok;
		}

		/**
		 * User has set profiler on demand and is requesting it to start profiling via url.
		 * Must set cookie and redirect (despite a method shouldn't retrieve true/false or redirect, I know)
		 */
		$cookie_name_fallover = 'XHPROF_FUELPHP';

		if (\Config::get('xhprof.profile_on') === Xhprof::XHPROF_PROFILE_ON_DEMAND
				and \Input::get(\Config::get('xhprof.get_parameter_activation')) === '1')
		{

			\Fuel\Core\Cookie::set(\Config::get('xhprof.cookie_name', $cookie_name_fallover), true, time() - 68400, '/');
			$redirect_url = rtrim(str_ireplace(\Config::get('xhprof.get_parameter_activation') . '=1', '', \Input::server('REQUEST_URI')), '?');

			\Response::redirect($redirect_url, 'refresh');
		}

		/**
		 * User has set profiler off. 
		 * Delete cookie and refresh
		 */
		if (\Config::get('xhprof.profile_on') === Xhprof::XHPROF_PROFILE_ON_DEMAND
				and \Input::get(\Config::get('xhprof.get_parameter_activation')) === '0')
		{
			//\Fuel\Core\Cookie::set(\Config::get('xhprof.profile_on', $cookie_name_fallover), false, time() - 68400, '/');
			\Cookie::delete(\Config::get('xhprof.cookie_name', $cookie_name_fallover));

			$redirect_url = rtrim(str_ireplace(\Config::get('xhprof.get_parameter_activation') . '=0', '', \Input::server('REQUEST_URI')), '?');

			\Response::redirect($redirect_url, 'refresh');
		}

		\Config::get('xhprof.ignored_extensions');

		end_function_ok:
		return true;

		end_function_ko:
		return false;

	}

	/**
	 * This is where the profiling starts
	 * @return boolean
	 */
	public static function run()
	{

		if (self::is_profilable() === false)
		{
			return false;
		}

		/**
		 * Checks when to start profiling.
		 * If not set will start now
		 */
		$event = \Config::get('xhprof.start_profiling_event', null);

		if ($event === null)
		{
			self::start_profiling();
		}
		else
		{
			\Event::register($event, 'Xhprof::start_profiling');
		}

	}

	/**
	 * Sets xhprof to start collecting data and programs
	 * the saving of the data for later
	 */
	public static function start_profiling()
	{
		/**
		 * Starts profiling
		 */
		xhprof_enable(
				\Config::get('xhprof.flags', null), array(
			'ignored_functions' => \Config::get('xhprof.ignored_functions', array())
		));

		/**
		 * Program where/when the profiler will stop collecting data and 
		 * save it to db.
		 * If not set, it will be at shutdown
		 */
		$event = \Config::get('xhprof.end_profiling_event', null);

		if ($event === null)
		{
			\Event::register('shutdown', 'Xhprof::save_profiling');
		}
		else
		{
			\Event::register($event, 'Xhprof::save_profiling');
		}

	}

	/**
	 * Finishes to collect data and create a run model to save it.
	 * 
	 */
	public static function save_profiling()
	{

		/**
		 * Profiling data fetched from xhprof's extension
		 */
		$xhprof_data = xhprof_disable();

		/**
		 * Need to create a run model and save its data in db
		 */
		$xhprof_model = new Model_Run();

		$xhprof_model->set_id(uniqid())
				->set_url(\Input::server('REQUEST_URI', 'Undefined'))
				->set_normalized_url(\Input::uri())
				->set_timestamp(date('Y-m-d H:i:s'))
				->set_server_name(\Input::server('SERVER_NAME', 'Undefined'))
				->set_profile_data($xhprof_data)
				->set_cookie(\Input::cookie())
				->set_post(\Input::post())
				->set_get(\Input::get())
				->set_peak_memory_usage(isset($xhprof_data['main()']['pmu']) ? $xhprof_data['main()']['pmu'] : null)
				->set_cpu_time(isset($xhprof_data['main()']['cpu']) ? $xhprof_data['main()']['cpu'] : null)
				->set_wall_time(isset($xhprof_data['main()']['wt']) ? $xhprof_data['main()']['wt'] : null)
				->set_server_id(\Input::server('SERVER_NAME', 'Undefined'));

		/**
		 * Finally save to db
		 */
		$xhprof_model->save_run();

	}

	/**
	 * Returns if the app can be profiled
	 * @return bool
	 */
	public static function is_profilable()
	{
		return self::$_is_profilable;

	}

	/**
	 * Sets if the app can be profiled
	 * @param bool $status
	 */
	protected static function set_profilable($status)
	{
		self::$_is_profilable = ((bool) $status === true) ? true : false;

	}

}
