<?php

namespace PhpLogger\Test;

use PhpLogger\Logger;

class LoggerTest extends \PHPUnit_Framework_TestCase
{

    public function testLog()
    {

        $logFile = array(
            'logDir' => __DIR__,
            'name' => 'test',
            'ext' => 'log',
            'dateFormat' => 'd-m-Y H:i:s P',
            'maxLogs' => 2,
            'maxSize' => 1
        );

        $log = new Logger(true, $logFile);
        
        $message = 'Testing message';
        $log->debug($message);
        $log->info($message);
        $log->warning($message);
        $log->success($message);
        $log->error($message);
        $log->fatal($message);
        $log->custom($message, 'red', 'black');

        $this->assertInstanceOf('PhpLogger\Logger', $log);
        $this->assertFileExists(__DIR__ . '/test.log');
        unlink(__DIR__ . '/test.log');
    }

    public function testLogger()
    {

        $logFile = array(
            'logDir' => __DIR__,
            'name' => 'test',
            'ext' => 'log',
            'dateFormat' => 'd-m-Y H:i:s P',
            'maxLogs' => 2,
            'maxSize' => 1
        );

        $log = new Logger(true, $logFile);
        
        $message = 'Testing message';
        $log->debug($message);
        $log->info($message);
        $log->warning($message);
        $log->success($message);
        $log->error($message);
        $log->fatal($message);
        $log->custom($message, 'red', 'black');

        $this->assertInstanceOf('PhpLogger\Logger', $log);
        $this->assertFileExists(__DIR__ . '/test.log');
        unlink(__DIR__ . '/test.log');
    }

}
