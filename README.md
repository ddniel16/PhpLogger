# Php-Logger
System logs in php, with options to register in syslog or in a custom file, with different priorities and in the case of logs to the console, with distinctive colors for each type.

INSTALL
-------

Using composer:
````
composer require ddniel16/php-logger:dev-master
````

or: 
````
composer.json

    "require": {
        "ddniel16/php-logger": "v2.0.0"
    }
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
use PhpLogger\Syslog;

$syslog = new Syslog('Php-Logger');

$log = new Logger();
$log->setSyslog($syslog);

$log->error('error message');
````

#File

Written to the file with a message depending on the severity
````php
use PhpLogger\Logger;
use PhpLogger\File;

$logFile = array(
    'logDir' => '/tmp',
    'name' => 'test',
    'ext' => 'log',
    'dateFormat' => 'd-m-Y H:i:s P',
    'maxLogs' => 1,
    'maxSize' => 123123154
);

$file = new File($logFile);

$log = new Logger();
$log->setFile($file);

$log->debug('debug message');
````

#Sql


````sql
CREATE TABLE `PhpLogger` (
    `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `priority` varchar(55) DEFAULT NULL,
    `log` text,
    `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
````


````php
use PhpLogger\Sql;
use PhpLogger\Logger;

$sql = new Sql();
$sql->setUser('user')
    ->setPassword('pass')
    ->setHost('localhost')
    ->setDbName('testing');

$log = new Logger();
$log->setSql($sql);

$log->debug('debug message');

````
