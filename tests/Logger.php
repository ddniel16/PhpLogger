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
            'maxSize' => 3
        );

        $log = new Logger('SyslogTag', $logFile);
        
        $message = 'Testing message';
        $log->debug($message);
        $log->info($message);
        $log->warning($message);
        $log->success($message);
        $log->error($message);
        $log->fatal($message);
        $log->custom($message, LOG_DEBUG, '[custom]', 'red', 'black');
        $log->custom($message, LOG_DEBUG, '[custom]', 97, 43);
        $log->custom($message, LOG_DEBUG, '[custom]', '97', '43');
        $log->custom($message, LOG_DEBUG, '[custom]', true, false);

        for ($i = 1; $i <= 10; $i++) {
            $log->info($message);
        }

        $this->assertInstanceOf('PhpLogger\Logger', $log);
        $this->assertFileExists(__DIR__ . '/test.log');
        $this->assertFileExists(__DIR__ . '/test.2.log');
        
        unlink(__DIR__ . '/test.log');
        unlink(__DIR__ . '/test.2.log');

    }

    public function testMaxSize()
    {

        $logFile = array(
            'logDir' => __DIR__,
            'name' => 'test',
            'ext' => 'log',
            'dateFormat' => 'd-m-Y H:i:s P',
            'maxLogs' => 2,
            'maxSize' => '3a'
        );

        $log = new Logger('SyslogTag', $logFile);
        
        $message = 'Testing message';
        $log->debug($message);


        $this->assertInstanceOf('PhpLogger\Logger', $log);
        $this->assertFileExists(__DIR__ . '/test.log');
        
        unlink(__DIR__ . '/test.log');

    }

}