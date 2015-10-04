# Php-Logger
System logs in php, with options to register in syslog or in a custom file, with different priorities and in the case of logs to the console, with distinctive colors for each type.

INSTALL
-------

Using composer:
````
composer require ddniel16/php-logger:dev-master
````

#Method's
available methods:

````php
echo $log->debug($message);
echo $log->info($message);
echo $log->warning($message);
echo $log->success($message);
echo $log->error($message);
echo $log->fatal($message);
echo $log->custom($message);
````

Examples
--------

#Syslog
Write to syslog with the severity of the method or be instructed.

````php
use PhpLogger\Logger;

$syslogTag = 'test-log';
$log = new Logger($syslogTag, false);

$log->debug('debug message');
````

#File

Written to the file with a message depending on the severity
````php
use PhpLogger\Logger;

$logFile = array(
    'logDir' => '/tmp',
    'name' => 'test',
    'ext' => 'log',
    'dateFormat' => 'd-m-Y H:i:s P',
    'maxLogs' => 1,
    'maxSize' => 123123154
);

$log = new Logger(false, $logFile);

$log->debug('debug message');
````

