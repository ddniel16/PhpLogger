<?php

namespace PhpLogger;

/**
 * @link    https://github.com/ddniel16/php-logger
 * @author  ddniel16 <ddniel16@gmail.com>
 * @license MIT
 */
class File
{

    protected $_file;

    public function __construct($file)
    {

           $default = array(
            'logDir' => sys_get_temp_dir(),
            'name' => 'easy-log',
            'ext' => 'log',
            'dateFormat' => 'd-m-Y H:i:s P',
            'maxLogs' => 1,
            'maxSize' => 123123154
        );

       $this->_file = array_merge($default, $file);

    }

    public function writeLog($message, $status = '[debug]', $priority = LOG_DEBUG)
    {

        $files = array();
        $logOpts = $this->_file;

        $logMaxSize = $logOpts['maxSize'];
        if (!is_numeric($logMaxSize)) {
            $logMaxSize = 104857600;
        }

        $listFiles = scandir($logOpts['logDir']);
        if (!empty($listFiles)) {
            foreach ($listFiles as $file) {
                $info = pathinfo($file);
                if (isset($info['extension']) && $info['extension'] === $logOpts['ext']) {
                    $files[] = $file;
                }
                
            }
        }

        $logName = $logOpts['name']  . '.' . $logOpts['ext'];
        $logFile = $logOpts['logDir'] . '/' . $logName;

        if (!file_exists($logFile)) {
            $log = fopen($logFile, 'w');
            fclose($log);
        }

        $this->_realSize($logFile);
        $fileSize = filesize($logFile);

        if ($fileSize > $logMaxSize) {

            $numFile = sizeof($files) + 1;
            if ($numFile <= $logOpts['maxLogs']) {

                $pathInfo = pathinfo($logFile);
                $path = realpath($pathInfo['dirname']);
                $newName = $pathInfo['filename'] . '.' . ($numFile) . '.' . $pathInfo['extension'];

                rename($logFile, $path . '/' . $newName);

                $log = fopen($logFile, 'w');
                fclose($log);
            }
        }

        $date = date($logOpts['dateFormat']);
        
        file_put_contents(
            $logFile, 
            $date . ': ' . $status . ' ' . print_r($message, true) . PHP_EOL,
            FILE_APPEND | LOCK_EX
        );

    }

    protected function _realSize($logFile)
    {

        $tmp = tempnam(sys_get_temp_dir(), 'tmp');
        copy($logFile, $tmp);

        $size = filesize($tmp);

        unlink($tmp);

        return $size;
    }

}