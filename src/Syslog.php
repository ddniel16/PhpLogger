<?php

namespace PhpLogger;

/**
 * @link    https://github.com/ddniel16/php-logger
 * @author  ddniel16 <ddniel16@gmail.com>
 * @license MIT
 */
class Syslog
{

    protected $_syslogTag;

    public function __construct($syslogTag = 'PhpLogger')
    {
        $this->_syslogTag = $syslogTag;
    }

    /**
     *
     * @param String $message
     * @param Constante $priority
     */
    public function writeLog($message, $priority = LOG_DEBUG)
    {

        openlog($this->_syslogTag, LOG_NDELAY | LOG_PID, LOG_LOCAL0);
        syslog($priority, print_r($message, true));

    }

}
