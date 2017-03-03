<?php

/**
 * Class "PhpLogger"
 *
 * PHP version 5.6/7
 *
 * @package PhpLogger
 * @author  "Daniel Rendon Arias (ddniel16)" <ddniel16@gmail.com>
 * @license https://opensource.org/licenses/EUPL-1.1 European Union Public Licence (V. 1.1)
 * @version Release: @package_version@
 * @link    https://github.com/ddniel16/php-logger
 */

namespace PhpLogger;

/**
 * This class manages the logs
 *
 * @package PhpLogger
 * @author  "Daniel Rendon Arias (ddniel16)" <ddniel16@gmail.com>
 * @license https://opensource.org/licenses/EUPL-1.1 European Union Public Licence (V. 1.1)
 * @version Release: @package_version@
 * @link    https://github.com/ddniel16/php-logger
 */
class PhpLogger
    extends Logger
        implements \Psr\Log\LoggerInterface
{

    /**
     * Creates new DateTimeZone object
     *
     * @link http://www.php.net/manual/en/datetimezone.construct.php
     * @var string
     */
    protected $_dateTimeZone = 'UTC';

    /**
     * Returns date formatted according to given format
     *
     * @link http://www.php.net/manual/en/datetime.format.php
     * @var string
     */
    protected $_dateFormat = 'Y-m-d H:i:s';

    /**
     * @var SyslogInterface
     */
    protected $_syslog;

    /**
     * @var FileInterface
     */
    protected $_file;

    /**
     * @var CustomInterface
     */
    protected $_custom;

    /**
     * @var boolean
     */
    protected $_output = false;

    /**
     * Get output value
     *
     * Print message
     *
     * @return boolean
     */
    public function getOutput()
    {
        return $this->_output;
    }

    /**
     * Get output value
     *
     * Print message
     *
     * @param boolean $output
     * @return \PhpLogger\PhpLogger
     */
    public function setOutput($output = false)
    {
        $this->_output = $output;
        return $this;
    }

    /**
     * Logger for syslog
     *
     * @param SyslogInterface $syslog
     */
    public function setSyslog(SyslogInterface $syslog)
    {
        $this->_syslog = $syslog;
    }

    /**
     * logger in to files
     *
     * @param FileInterface $file
     */
    public function setFile(FileInterface $file)
    {
        $this->_file = $file;
    }

    /**
     * custom logger
     *
     * @param CustomInterface $custom
     */
    public function setCustom(CustomInterface $custom)
    {
        $this->_custom = $custom;
    }

    /**
     * Prepare message from send loggers
     *
     * @param unknown $message
     * @param array $context
     * @param string $priority
     * @param string $priorityMsg
     * @param string $color
     * @return string
     */
    protected function _processLog(
        $message,
        array $context = array(),
        $priority = LOG_DEBUG,
        $priorityMsg = '[debug]',
        $color = '39'
    )
    {

        $date = new \DateTime('now', new \DateTimeZone($this->_dateTimeZone));
        $date = $date->format($this->_dateFormat);

        $log = \PhpLogger\Tools::interpolate($message, $context);

        if ($this->_syslog instanceof SyslogInterface) {
            $this->_syslog->writeLog($log, $priority, $priorityMsg);
        }

        if ($this->_file instanceof FileInterface) {
            $this->_file->writeLog($log, $priority, $priorityMsg);
        }

        if ($this->_custom instanceof CustomInterface) {
            $this->_custom->writeLog($log, $priority, $priorityMsg);
        }

        $finalLog = sprintf(
            "\033[%sm%s %s %s \033[0m" . PHP_EOL,
            $color,
            $date,
            $priorityMsg,
            print_r($log, true)
        );

        if ($this->getOutput()) {
            echo $finalLog;
        }

        return $finalLog;

    }

}
