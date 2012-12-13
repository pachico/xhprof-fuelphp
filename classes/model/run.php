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

/**
 * 
 */
class Model_Run extends \Model
{

	/**
	 *
	 * @var string
	 */
	protected $_id = null;

	/**
	 *
	 * @var string
	 */
	protected $_url = null;

	/**
	 *
	 * @var string
	 */
	protected $_normalized_url = null;

	/**
	 *
	 * @var string
	 */
	protected $_timestamp = null;

	/**
	 *
	 * @var string
	 */
	protected $_server_name = null;

	/**
	 *
	 * @var array
	 */
	protected $_profile_data = null;

	/**
	 *
	 * @var int
	 */
	protected $_type = null;

	/**
	 *
	 * @var array
	 */
	protected $_cookie = null;

	/**
	 *
	 * @var array
	 */
	protected $_post = null;

	/**
	 *
	 * @var array
	 */
	protected $_get = null;

	/**
	 * Change in PHP peak memory usage in bar() when called from foo()
	 * @var int
	 */
	protected $_peak_memory_usage = null;

	/**
	 * Time in bar() when called from foo()
	 * @var int 
	 */
	protected $_wall_time = null;

	/**
	 * cpu time in bar() when called from foo()
	 * @var int
	 */
	protected $_cpu_time = null;

	/**
	 *
	 * @var string
	 */
	protected $_server_id = null;

	/**
	 *
	 * @var \Database_Connection
	 */
	protected static $_db_connection = null;

	/**
	 * 
	 */
	public function __construct()
	{
		self::$_db_connection = \Database_Connection::instance('xhprof');

	}

	/**
	 * 
	 * @return string
	 */
	public function get_id()
	{
		return $this->_id;

	}

	/**
	 * 
	 * @param string $_id
	 * @return \Xhprof\Model_Run
	 */
	public function set_id($_id)
	{
		$this->_id = $_id;
		return $this;

	}

	/**
	 * 
	 * @return string
	 */
	public function get_url()
	{
		return $this->_url;

	}

	/**
	 * 
	 * @param string $_url
	 * @return \Xhprof\Model_Run
	 */
	public function set_url($_url)
	{
		$this->_url = $_url;
		return $this;

	}

	/**
	 * 
	 * @return string
	 */
	public function get_normalized_url()
	{
		return $this->_normalized_url;

	}

	/**
	 * 
	 * @param string $_normalized_url
	 * @return \Xhprof\Model_Run
	 */
	public function set_normalized_url($_normalized_url)
	{
		$this->_normalized_url = $_normalized_url;
		return $this;

	}

	/**
	 * 
	 * @return string
	 */
	public function get_timestamp()
	{
		return $this->_timestamp;

	}

	/**
	 * 
	 * @param string $_timestamp
	 * @return \Xhprof\Model_Run
	 */
	public function set_timestamp($_timestamp)
	{
		$this->_timestamp = $_timestamp;
		return $this;

	}

	/**
	 * 
	 * @return string
	 */
	public function get_server_name()
	{
		return $this->_server_name;

	}

	/**
	 * 
	 * @param string $_server_name
	 * @return \Xhprof\Model_Run
	 */
	public function set_server_name($_server_name)
	{
		$this->_server_name = $_server_name;
		return $this;

	}

	/**
	 * 
	 * @return array
	 */
	public function get_profile_data()
	{
		return $this->_profile_data;

	}

	/**
	 * 
	 * @param array $_profile_data
	 * @return \Xhprof\Model_Run
	 */
	public function set_profile_data($_profile_data)
	{
		$this->_profile_data = $_profile_data;
		return $this;

	}

	/**
	 * 
	 * @return int
	 */
	public function get_type()
	{
		return $this->_type;

	}

	/**
	 * 
	 * @param int $_type
	 * @return \Xhprof\Model_Run
	 */
	public function set_type($_type)
	{
		$this->_type = $_type;
		return $this;

	}

	/**
	 * 
	 * @return array
	 */
	public function get_cookie()
	{
		return $this->_cookie;

	}

	/**
	 * 
	 * @param array $_cookie
	 * @return \Xhprof\Model_Run
	 */
	public function set_cookie($_cookie)
	{
		$this->_cookie = $_cookie;
		return $this;

	}

	/**
	 * 
	 * @return array
	 */
	public function get_post()
	{
		return $this->_post;

	}

	/**
	 * 
	 * @param array $_post
	 * @return \Xhprof\Model_Run
	 */
	public function set_post($_post)
	{
		$this->_post = $_post;
		return $this;

	}

	/**
	 * 
	 * @return array
	 */
	public function get_get()
	{
		return $this->_get;

	}

	/**
	 * 
	 * @param array $_get
	 * @return \Xhprof\Model_Run
	 */
	public function set_get($_get)
	{
		$this->_get = $_get;
		return $this;

	}

	/**
	 * 
	 * @return int
	 */
	public function get_peak_memory_usage()
	{
		return $this->_peak_memory_usage;

	}

	/**
	 * 
	 * @param int $_peak_memory_usage
	 * @return \Xhprof\Model_Run
	 */
	public function set_peak_memory_usage($_peak_memory_usage)
	{
		$this->_peak_memory_usage = $_peak_memory_usage;
		return $this;

	}

	/**
	 * 
	 * @return int
	 */
	public function get_wall_time()
	{
		return $this->_wall_time;

	}

	/**
	 * 
	 * @param int $_wall_time
	 * @return \Xhprof\Model_Run
	 */
	public function set_wall_time($_wall_time)
	{
		$this->_wall_time = $_wall_time;
		return $this;

	}

	/**
	 * 
	 * @return int
	 */
	public function get_cpu_time()
	{
		return $this->_cpu_time;

	}

	/**
	 * 
	 * @param int $_cpu_time
	 * @return \Xhprof\Model_Run
	 */
	public function set_cpu_time($_cpu_time)
	{
		$this->_cpu_time = $_cpu_time;
		return $this;

	}

	/**
	 * 
	 * @return string
	 */
	public function get_server_id()
	{
		return $this->_server_id;

	}

	/**
	 * 
	 * @param string $_server_id
	 * @return \Xhprof\Model_Run
	 */
	public function set_server_id($_server_id)
	{
		$this->_server_id = $_server_id;
		return $this;

	}

	/**
	 * This method performs the saving to database
	 * @return array
	 */
	public function save_run()
	{

		// $query = "INSERT INTO `details` (`id`, `url`, `c_url`, `timestamp`, `server name`, `perfdata`, `type`, `cookie`, `post`, `get`, `pmu`, `wt`, `cpu`, `server_id`, `aggregateCalls_include`) VALUES('$run_id', '{$sql['url']}', '{$sql['c_url']}', FROM_UNIXTIME('{$sql['timestamp']}'), '{$sql['servername']}', '{$sql['data']}', '{$sql['type']}', '{$sql['cookie']}', '{$sql['post']}', '{$sql['get']}', '{$sql['pmu']}', '{$sql['wt']}', '{$sql['cpu']}', '{$sql['server_id']}', '{$sql['aggregateCalls_include']}')";

		list($insert_id, $rows_affected) = \DB::insert('details')->set(array(
					'id' => $this->get_id(),
					'url' => $this->get_url(),
					'c_url' => $this->get_normalized_url(),
					'timestamp' => $this->get_timestamp(),
					'server name' => $this->get_server_name(),
					'perfdata' => gzcompress(serialize($this->get_profile_data()), 2),
					'type' => $this->get_type(),
					'cookie' => gzcompress(serialize($this->get_cookie()), 2),
					'post' => gzcompress(serialize($this->get_post()), 2),
					'get' => gzcompress(serialize($this->get_get()), 2),
					'pmu' => $this->get_peak_memory_usage(),
					'wt' => $this->get_wall_time(),
					'cpu' => $this->get_cpu_time()
				))->execute(self::$_db_connection);

		return array($insert_id, $rows_affected);

	}

}
