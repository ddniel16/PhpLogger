<?php

/**
 * Class "Logger"
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
 * Class "Logger"
 *
 * @package PhpLogger
 * @author  "Daniel Rendon Arias (ddniel16)" <ddniel16@gmail.com>
 * @license https://opensource.org/licenses/EUPL-1.1 European Union Public Licence (V. 1.1)
 * @version Release: @package_version@
 * @link    https://github.com/ddniel16/php-logger
 */
class Logger implements \Psr\Log\LoggerInterface
{

    protected $_debugColor   = 39;
    protected $_infoColor    = 96;
    protected $_warningColor = 93;
    protected $_successColor = 92;
    protected $_errorColor   = 91;
    protected $_fatalColor   = 91;

    /**
     * {@inheritDoc}
     * @see \Psr\Log\LoggerInterface::emergency()
     */
    public function emergency(
        $message,
        array $context = array(),
        $priority = LOG_EMERG
    )
    {
        return $this->_processLog(
            $message,
            $context,
            $priority,
            '[emergency]',
            $this->_fatalColor
        );
    }

    /**
     * {@inheritDoc}
     * @see \Psr\Log\LoggerInterface::alert()
     */
    public function alert(
        $message,
        array $context = array(),
        $priority = LOG_ALERT
    )
    {
        return $this->_processLog(
            $message,
            $context,
            $priority,
            '[fatal]',
            $this->_fatalColor
        );
    }

    /**
     * {@inheritDoc}
     * @see \Psr\Log\LoggerInterface::critical()
     */
    public function critical(
        $message,
        array $context = array(),
        $priority = LOG_CRIT
    )
    {
        return $this->_processLog(
            $message,
            $context,
            $priority,
            '[critical]',
            $this->_fatalColor
        );
    }

    /**
     * {@inheritDoc}
     * @see \Psr\Log\LoggerInterface::error()
     */
    public function error(
        $message,
        array $context = array(),
        $priority = LOG_ERR
    )
    {
        return $this->_processLog(
            $message,
            $context,
            $priority,
            '[error]',
            $this->_errorColor
        );
    }

    /**
     * {@inheritDoc}
     * @see \Psr\Log\LoggerInterface::warning()
     */
    public function warning(
        $message,
        array $context = array(),
        $priority = LOG_WARNING
    )
    {
        return $this->_processLog(
            $message,
            $context,
            $priority,
            '[warning]',
            $this->_warningColor
        );
    }

    /**
     * {@inheritDoc}
     * @see \Psr\Log\LoggerInterface::notice()
     */
    public function notice(
        $message,
        array $context = array(),
        $priority = LOG_NOTICE
    )
    {
        return $this->_processLog(
            $message,
            $context,
            $priority,
            '[notice]',
            $this->_infoColor
        );
    }

    /**
     * {@inheritDoc}
     * @see \Psr\Log\LoggerInterface::info()
     */
    public function info(
        $message,
        array $context = array(),
        $priority = LOG_INFO
    )
    {
        return $this->_processLog(
            $message,
            $context,
            $priority,
            '[info]',
            $this->_infoColor
        );
    }

    /**
     * {@inheritDoc}
     * @see \Psr\Log\LoggerInterface::debug()
     */
    public function debug(
        $message,
        array $context = array(),
        $priority = LOG_DEBUG
    )
    {
        return $this->_processLog(
            $message,
            $context,
            $priority,
            '[debug]',
            $this->_debugColor
        );
    }

    /**
     * {@inheritDoc}
     * @see \Psr\Log\LoggerInterface::log()
     */
    public function log(
        $level,
        $message,
        array $context = array(),
        $priority = LOG_DEBUG
    )
    {
        return $this->_processLog(
            $message,
            $context,
            $priority,
            '[log]',
            $this->_successColor
        );
    }

    /**
     * End from event.
     *
     * Example: Email sent!
     *
     * @param unknown $message
     * @param array $context
     * @param string $priority
     */
    public function success(
        $message,
        array $context = array(),
        $priority = LOG_INFO
    )
    {
        return $this->_processLog(
            $message,
            $context,
            $priority,
            '[success]',
            $this->_successColor
        );
    }

    /**
     *
     * @param unknown $message
     * @param array $context
     * @param string $priority
     * @param string $tag
     * @param number $fontColor
     * @param number $backgroundColor
     * @return string
     */
    public function custom(
        $message,
        array $context = array(),
        $priority = LOG_DEBUG,
        $tag = '[custom]',
        $fontColor = 39,
        $backgroundColor = 49
    )
    {

        $color = \PhpLogger\Tools::checkFontColor($fontColor);
        $background = \PhpLogger\Tools::checkBackgroundColor($backgroundColor);

        $log = $this->_processLog(
            $message,
            $context,
            $priority,
            $tag,
            $fontColor
        );

        $back = "\033[" . $background . "m";
        $font = "\033[" . $color . "m";
        $content = print_r($log, true);

        return $back . $font . $content . "\033[0m" . PHP_EOL;

    }

}