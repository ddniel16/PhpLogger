<?php

/**
 * @link    https://github.com/ddniel16/php-logger
 * @author  ddniel16 <ddniel16@gmail.com>
 * @license MIT
 */
class PhpLogger
{

    protected $_default = "\033[0m";
    protected $_syslogTag;
    protected $_file;

    private $_fontColors = array(
        'default' => 39,
        'white' => 97,
        'black' => 30,
        'red' => 31,
        'green' => 32,
        'yellow' => 33,
        'blue' => 34,
        'purple' => 35,
        'cyan' => 36,
        'lightRed' => 91,
        'lightGreen' => 92,
        'lightYellow' => 93,
        'lightBlue' => 94,
        'lightPurple' => 95,
        'lightCyan' => 96
    );

    private $_backgroundColors = array(
        'default' => 49,
        'white' => 107,
        'black' => 40,
        'red' => 41,
        'green' => 42,
        'yellow' => 43,
        'blue' => 44,
        'purple' => 45,
        'cyan' => 46,
        'lightRed' => 101,
        'lightGreen' => 102,
        'lightYellow' => 103,
        'lightBlue' => 104,
        'lightPurple' => 105,
        'lightCyan' => 106
    );

    public function __construct($syslog = false, $file = false)
    {

        $this->_syslogTag = $syslog;

        $default = array(
            'logDir' => sys_get_temp_dir(),
            'name' => 'easy-log',
            'ext' => 'log',
            'dateFormat' => 'd-m-Y H:i:s P',
            'maxLogs' => 1,
            'maxSize' => 123123154
        );

        if ($file === false) {
            $this->_file = $file;
        } else {
            $this->_file = array_merge($default, $file);
        }

    }

    public function debug($log, $priority = LOG_DEBUG)
    {

        if ($this->_syslogTag !== false) {
            $this->_syslog($log, $priority);
        }

        if ($this->_file) {
            $this->_customFile($log, '[debug]', $priority);
        }

        return "\033[39m" . print_r($log, true) . $this->_default . PHP_EOL;

    }

    public function info($log, $priority = LOG_INFO)
    {

        if ($this->_syslogTag !== false) {
            $this->_syslog($log, $priority);
        }

        if ($this->_file) {
            $this->_customFile($log, '[info]', $priority);
        }

        return "\033[96m" . print_r($log, true) . $this->_default . PHP_EOL;

    }

    public function warning($log, $priority = LOG_WARNING)
    {

        if ($this->_syslogTag !== false) {
            $this->_syslog($log, $priority);
        }

        if ($this->_file) {
            $this->_customFile($log, '[warning]', $priority);
        }

        return "\033[93m" . print_r($log, true) . $this->_default . PHP_EOL;

    }

    public function success($log, $priority = LOG_DEBUG)
    {

        if ($this->_syslogTag !== false) {
            $this->_syslog($log, $priority);
        }

        if ($this->_file) {
            $this->_customFile($log, '[success]', $priority);
        }

        return "\033[92m" . print_r($log, true) . $this->_default . PHP_EOL;

    }

    public function error($log, $priority = LOG_ERR)
    {

        if ($this->_syslogTag !== false) {
            $this->_syslog($log, $priority);
        }

        if ($this->_file) {
            $this->_customFile($log, '[error]', $priority);
        }

        return "\033[91m" . print_r($log, true) . $this->_default . PHP_EOL;

    }

    public function fatal($log, $priority = LOG_ALERT)
    {

        if ($this->_syslogTag !== false) {
            $this->_syslog($log, $priority);
        }

        if ($this->_file) {
            $this->_customFile($log, '[fatal]', $priority);
        }

        return "\033[91m" . print_r($log, true) . $this->_default . PHP_EOL;

    }

    public function custom($log, $fontColor = 39, $backgroundColor = 49)
    {

        $color = $this->_checkFontColor($fontColor);
        $background = $this->_checkBackgroundColor($backgroundColor);

        if ($this->_syslogTag !== false) {
            $this->_syslog($log, LOG_ERR);
        }

        if ($this->_file) {
            $this->_customFile($log);
        }

        $back = "\033[" . $background . "m";
        $font = "\033[" . $color . "m";
        $content = print_r($log, true);

        return $back . $font . $content . $this->_default . PHP_EOL;

    }

    protected function _checkFontColor($fontColor)
    {

        if (gettype($fontColor) === 'integer') {

            $values = array_values($this->_fontColors);

            if (array_search($fontColor, $values) !== false) {
                return $fontColor;
            }

        } elseif (gettype($fontColor) === 'string') {

            if (array_key_exists($fontColor, $this->_fontColors)) {
                return $this->_fontColors[$fontColor];
            }

        }

        return 39;

    }

    protected function _checkBackgroundColor($backgroundColor)
    {

        if (gettype($backgroundColor) === 'integer') {

            $values = array_values($this->_backgroundColors);

            if (array_search($backgroundColor, $values) !== false) {
                return $backgroundColor;
            }

        } elseif (gettype($backgroundColor) === 'string') {

            if (array_key_exists($backgroundColor, $this->_backgroundColors)) {
                return $this->_backgroundColors[$backgroundColor];
            }

        }

        return 49;

    }

    /**
     *
     * @param String $message
     */
    protected function _customFile($message, $status = '', $priority = LOG_DEBUG)
    {

        $logOpts = $this->_file;

        $logMaxSize = $logOpts['maxSize'];
        if (!is_numeric($logMaxSize)) {
            $logMaxSize = 104857600;
        }

        $logName = $logOpts['name']  . '.' . $logOpts['ext'];
        $logFile = $logOpts['logDir'] . '/' . $logName;

        if (!file_exists($logFile)) {
            $log = fopen($logFile, 'w');
            fclose($log);
        }

        $fileSize = filesize($logFile);

        if ($fileSize > $logMaxSize) {

            $pathInfo = pathinfo($logFile);
            $path = realpath($pathInfo['dirname']);
            $newName = $pathInfo['filename'] . '2.' . $pathInfo['extension'];

            rename($logFile, $path . '/' . $newName);

            $log = fopen($logFile, 'w');
            fclose($log);

        }

        $date = date($logOpts['dateFormat']);

        file_put_contents(
            $logFile, 
            $date . ': ' . $status . ' ' . print_r($message, true) . PHP_EOL,
            FILE_APPEND | LOCK_EX
        );

    }

    /**
     *
     * @param String $message
     * @param Constante $priority
     */
    protected function _syslog($message, $priority = LOG_DEBUG)
    {

        if ($this->_syslogTag) {
            openlog($this->_syslogTag, LOG_NDELAY | LOG_PID, LOG_LOCAL0);
        }

        syslog($priority, print_r($message, true));

    }

    protected function _fileSizeConvert ($bytes)
    {

        $bytes = floatval($bytes);
        $arBytes = array(
            0 => array(
                'unit' => 'TB',
                'value' => pow(1024, 4)
            ),
            1 => array(
                'unit' => 'GB',
                'value' => pow(1024, 3)
            ),
            2 => array(
                'unit' => 'MB',
                'value' => pow(1024, 2)
            ),
            3 => array(
                'unit' => 'KB',
                'value' => 1024
            ),
            4 => array(
                'unit' => 'B',
                'value' => 1
            )
        );

        foreach ($arBytes as $arItem) {
            if ($bytes >= $arItem['value']) {
                $result = $bytes / $arItem['value'];
                $result = str_replace('.', ',', strval(round($result, 2))) . ' ' . $arItem['unit'];
                break;
            }
        }

        return $result;

    }

}