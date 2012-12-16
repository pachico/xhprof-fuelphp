#Requirements

* Apache
* PHP 5.3+
* MySQL
* Facebook's xhprof module
* Paul Reinheimer's fork of Facebook xhprof (viewer)

#What is xhprof-fuelphp and what is not

This package works has been specifically designed to work as a FuelPHP package therefore it won’t work in any other framework since it depends on core classes to run.
It saves profiling data collected by Facebook’s xhprof profiler (FXP) in database.
It can profile the application from FuelPHP app bootstrap to the shutdown event of it.
However, it can be configured to start and end collecting profiling data at any of the  system defined events of FuelPHP (http://fuelphp.com/docs/classes/event.html).
This means you can profile app from _request_started_ to _request_finished_, if configured.

This package does not include the FXP module, which you will have to compile and install in your Apache/PHP environment. Luckily, this is very simple and is described in the Install section.
This package does not contain the viewer for the collected data. The viewer used is Paul Reinheimer’s fork of Facebook’s Xhprof Profiler (https://github.com/preinheimer/xhprof.git).
comes together with FXP and is a simple app that only requires access to the same database this package saves data to.


#What is then Xhprof?

From the original source:
> XHProf is a hierarchical profiler for PHP. It reports function-level call counts and inclusive and exclusive metrics such as wall (elapsed) time, CPU time and memory usage. A function's profile can be broken down by callers or callees. The raw data collection component is implemented in C as a PHP Zend extension called xhprof. XHProf has a simple HTML based user interface (written in PHP). The browser based UI for viewing profiler results makes it easy to view results or to share results with peers. A callgraph image view is also supported.
> XHProf reports can often be helpful in understanding the structure of the code being executed. The hierarchical nature of the reports can be used to determine, for example, what chain of calls led to a particular function getting called.
> XHProf supports ability to compare two runs (a.k.a. "diff" reports) or aggregate data from multiple runs. Diff and aggregate reports, much like single run reports, offer "flat" as well as "hierarchical" views of the profile.
> XHProf is a light-weight instrumentation based profiler. During the data collection phase, it keeps track of call counts and inclusive metrics for arcs in the dynamic callgraph of a program. It computes exclusive metrics in the reporting/post processing phase. XHProf handles recursive functions by detecting cycles in the callgraph at data collection time itself and avoiding the cycles by giving unique depth qualified names for the recursive invocations.

##Then why to reinvent the wheel?

Because unfortunately, the original files to include to profile your app do an extensive usage of global variables and relies on the fact that you preappend and append files either in your php.ini or .htaccess.
I believe non of these two scenarios are optimal. In addition, ultimately, you want to have the same configuration in development and production environments.

#Installation

##Xhprof extension

https://github.com/preinheimer/xhprof.git

From original source:
> Note: A windows port hasn't been implemented yet. We have tested xhprof on Linux/FreeBSD so far.
Version 0.9.2 and above of XHProf is also expected to work on Mac OS. [We have tested on Mac OS 10.5.]
Note: XHProf uses the RDTSC instruction (time stamp counter) to implement a really low overhead timer for elapsed time. So at the moment xhprof only works on x86 architecture. Also, since RDTSC values may not be synchronized across CPUs, xhprof binds the program to a single CPU during the profiling period.
XHProf's RDTSC based timer functionality doesn't work correctly if SpeedStep technology is turned on. This technology is available on some Intel processors. [Note: Mac desktops and laptops typically have SpeedStep turned on by default. To use XHProf, you'll need to disable SpeedStep.]

> The steps below should work for Linux/Unix environments.
% cd <xhprof_source_directory>/extension/% phpize% ./configure --with-php-config=<path to php-config>% make% make install% make test
php.ini file: You can update your php.ini file to automatically load your extension. Add the following to your php.ini file.
[xhprof]extension=xhprof.so

##Xhprof viewer


This app will require a Mysql database where to store profiled data.
The definition of this is not very elegant but I’m forced to keep it as it is in order to be compatible with Facebook’s xhprof viewer.
Create the following db/table:
```
CREATE DATABSE ‘xhprof’;
USE ‘xhprof’;
CREATE TABLE IF NOT EXISTS `details` (
  `id` char(17) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `c_url` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `server name` varchar(64) DEFAULT NULL,
  `perfdata` mediumblob,
  `type` tinyint(4) DEFAULT NULL,
  `cookie` blob,
  `post` blob,
  `get` blob,
  `pmu` int(11) unsigned DEFAULT NULL,
  `wt` int(11) unsigned DEFAULT NULL,
  `cpu` int(11) unsigned DEFAULT NULL,
  `server_id` char(3) NOT NULL DEFAULT 't11',
  `aggregateCalls_include` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `url` (`url`),
  KEY `c_url` (`c_url`),
  KEY `cpu` (`cpu`),
  KEY `wt` (`wt`),
  KEY `pmu` (`pmu`),
  KEY `timestamp` (`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
```

Rename the file xhprof_lib/config.sample.php to xhprof_lib/config.php and edit the file setting the user credentials to access the db/table created above and the IPs allowed to access it (or disable the restriction).

Then create a virtualhost to point to xhprof_html/index.php and that’s all you need.

##Xhprof-FuelPHP package

Ths is the easy part.
Enter your packages folder:
```
cd /fuel/packages
```
clone the this package
```
git clone  https://github.com/pachico/xhprof-fuelphp.git
```
And append it to the end of your app’s bootstrap:
```
if (Fuel::$env === Fuel::DEVELOPMENT)
{
	\Package::load('xhprof-fuelphp');
	\Xhprof\Xhprof::run();
}
```
__Note__: that by doing this you will only be able to profile in Development environment.
Change it if required.

Configure the db config file (config/db.php) to match your mysql requirements.
Configure the xhprof config file (config/xhprof.php) to match your profiling preferences.

#Usage
In config/xhprof.php you will find 3 profiling policies.
If set to XHPROF_PROFILE_ALWAYS it will always profile your application.
If set to XHPROF_PROFILE_NEVER it will never profile it.
if set to XHPROF_PROFILE_ON_DEMAND you will need to append the param “_profile=1" in the URL to activate the profiler. You can simply disable it by appending “_profile=0".
If you are not happy with the name of this param, you can always change it in the configuration file (‘get_parameter_activation’).

You can set certain functions not to be profiled. To do that, list them in ‘ignored_functions’.

You can also set request file extensions not to be profiled. You set them in ‘ignored_extensions’.

The rest is simple. Profile your app and open the profiler viewer. Your app runs should be there.

#TODO

* Create a proper way to create db/table.
* Create the viewer as a FuelPHP application or module (help is welcome!).
