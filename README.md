# Php-Logger

System logs in php, with options to register in syslog or in a custom file, with different priorities and in the case of logs to the console, with distinctive colors for each type.

* [Install](#install)
* [Methods](#methods)
* [Examples](#examples)
  * [Syslog](#syslog)
  * [File](#file)
  * [Custom](#custom)

## Install

Using composer:

````
composer require ddniel16/php-logger
````

## Methods

available methods:

````php
$logs->alert($message, $context);
$logs->critical($message, $context);
$logs->custom($message, $context);
$logs->debug($message, $context);
$logs->emergency($message, $context);
$logs->error($message, $context);
$logs->info($message, $context);
$logs->log(0, $message, $context);
$logs->notice($message, $context);
$logs->success($message, $context);
$logs->warning($message, $context);
````

## Examples

````php
<?php

$logs = new \PhpLogger\PhpLogger();
$logs->setOutput(true);

$message = 'Hello Mr. {name} {lastname} Matrix awaits you!';
$context = array('name' => 'Jack', 'lastname' => 'Sparrow');

$logs->debug($message, $context);

````

### Syslog

Write to syslog with the severity of the method or be instructed.

````php
<?php

$syslog = new \PhpLogger\Syslog('testting');

$logger = new \PhpLogger\PhpLogger();
$logger->setSyslog($syslog);

$logger->debug('--> syslog <--');

````

### File

Written to the file with a message depending on the severity

````php
<?php

$optionsFile = array(
    'logDir' => __DIR__ . '/logs',
    'name' => 'php-logger',
    'ext' => 'log',
    'dateFormat' => 'd-m-Y H:i:s P',
    'maxLogs' => 3,
    'maxSize' => 700
);

$file = new \PhpLogger\File($logFile);

$logger = new \PhpLogger\PhpLogger();
$logger->setFile($file);

$logger->debug('debug message');

````

### Custom


````php
class CustomLogger implements PhpLogger\CustomInterface
{

    public function writeLog(
        $message,
        $priority = LOG_DEBUG,
        $priorityMsg = '[debug]'
    )
    {

        if ($priority === LOG_CRIT) {
            mail('user@example.com', $priorityMsg, $message);
        }

    }

}

$logs = new \PhpLogger\PhpLogger();
$logs->setCustom(new CustomLogger());
$logs->setOutput(false);

$message = 'Hola Sr. {name} {lastname}';
$context = array('name' => 'Jack', 'lastname' => 'Sparrow');

$logs->critical($message, $context);

````

