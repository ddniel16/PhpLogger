<?php

namespace PhpLogger;

/**
 * @link    https://github.com/ddniel16/php-logger
 * @author  ddniel16 <ddniel16@gmail.com>
 * @license MIT
 */
class Logger
{

    protected $_default = "\033[0m";

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

    protected $_debugColor   = 39;
    protected $_infoColor    = 96;
    protected $_warningColor = 93;
    protected $_successColor = 92;
    protected $_errorColor   = 91;
    protected $_fatalColor   = 91;

    protected $_file   = false;
    protected $_syslog = false;
    protected $_sql    = false;

    public function setFile(File $file)
    {
        $this->_file = $file;
    }
    
    public function setSyslog(Syslog $syslog)
    {
        $this->_syslog = $syslog;
    }
    
    public function setSql(Sql $sql)
    {
        $this->_sql = $sql;
    }

    public function debug($log, $priority = LOG_DEBUG)
    {

        $result = $this->_processLog($log, '[debug]', $priority, $this->_debugColor);
        return $result;

    }

    public function info($log, $priority = LOG_INFO)
    {

        $result = $this->_processLog($log, '[info]', $priority, $this->_infoColor);
        return $result;

    }

    public function warning($log, $priority = LOG_WARNING)
    {

        $result = $this->_processLog($log, '[warning]', $priority, $this->_warningColor);
        return $result;

    }

    public function success($log, $priority = LOG_DEBUG)
    {

        $result = $this->_processLog($log, '[success]', $priority, $this->_successColor);
        return $result;

    }

    public function error($log, $priority = LOG_ERR)
    {

        $result = $this->_processLog($log, '[error]', $priority, $this->_errorColor);
        return $result;

    }

    public function fatal($log, $priority = LOG_ALERT)
    {

        $result = $this->_processLog($log, '[fatal]', $priority, $this->_fatalColor);
        return $result;

    }

    public function custom($log, $priority = LOG_DEBUG, $tag = '[custom]', $fontColor = 39, $backgroundColor = 49)
    {

        $color = $this->_checkFontColor($fontColor);
        $background = $this->_checkBackgroundColor($backgroundColor);

        $this->_processLog($log, $tag, $priority, $fontColor);

        $back = "\033[" . $background . "m";
        $font = "\033[" . $color . "m";
        $content = print_r($log, true);

        return $back . $font . $content . $this->_default . PHP_EOL;

    }

    protected function _processLog($log, $priorityMsg, $priority, $color)
    {

        if ($this->_syslog !== false) {
            $this->_syslog->writeLog($log, $priority);
        }

        if ($this->_file) {
            $this->_file->writeLog($log, $priorityMsg, $priority);
        }

        if ($this->_sql) {
            $this->_sql->save($log, $priorityMsg);
        }

        return "\033[" . $color . "m" . print_r($log, true) . $this->_default . PHP_EOL;

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

}