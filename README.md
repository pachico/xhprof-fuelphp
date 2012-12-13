<h1>Introduction:</h1>

This package allows you to profile fuelphp applications using Facebook's xhprof extension (https://github.com/facebook/xhprof).
It will only take care of saving the profiling data in db so you will still need the xhprof viewer to see the results.

<h1>Installation</h1>
<h2>Xhprof extension</h2>
Taken from original source:<br />
Installing the XHProf Extension<br />
The extension lives in the "extension/" sub-directory.<br />
Note: A windows port hasn't been implemented yet. We have tested xhprof on Linux/FreeBSD so far.<br />
Version 0.9.2 and above of XHProf is also expected to work on Mac OS. [We have tested on Mac OS 10.5.]<br />
Note: XHProf uses the RDTSC instruction (time stamp counter) to implement a really low overhead timer for elapsed time. 
So at the moment xhprof only works on x86 architecture. 
Also, since RDTSC values may not be synchronized across CPUs, xhprof binds the program to a single CPU during the profiling period.<br />
XHProf's RDTSC based timer functionality doesn't work correctly if SpeedStep technology is turned on. This technology is available on some Intel processors. [Note: Mac desktops and laptops typically have SpeedStep turned on by default. To use XHProf, you'll need to disable SpeedStep.]
The steps below should work for Linux/Unix environments.<br />
<br />
% cd <xhprof_source_directory>/extension/<br />
% phpize<br />
% ./configure --with-php-config=<path to php-config><br />
% make<br />
% make install<br />
% make test<br />
php.ini file: You can update your php.ini file to automatically load your extension. Add the following to your php.ini file.<br />
<br />
[xhprof]<br />
extension=xhprof.so<br />
;<br />
; directory used by default implementation of the iXHProfRuns<br />
; interface (namely, the XHProfRuns_Default class) for storing<br />
; XHProf runs.<br />
;<br />
<br />
xhprof.output_dir=<directory_for_storing_xhprof_runs><br />
<br />
Create the database and table described in the db folder.<br />


<h2>FuelPHP package</h2>
Download the package and put it under fuel/packages/xhprof.<br />
Set the Config files under the config folder and add the following at the bottom of the app bootstrap file:<br />
<br />
if (Fuel::$env === Fuel::DEVELOPMENT)<br />
{<br />
  \Package::load('xhprof');<br />
	\Xhprof\Xhprof::run();<br />
}<br />

