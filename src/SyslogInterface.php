<?php

/**
 * interface "SyslogInterface"
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
 * SyslogInterface
 *
 * @package PhpLogger
 * @author  "Daniel Rendon Arias (ddniel16)" <ddniel16@gmail.com>
 * @license https://opensource.org/licenses/EUPL-1.1 European Union Public Licence (V. 1.1)
 * @version Release: @package_version@
 * @link    https://github.com/ddniel16/php-logger
 */
interface SyslogInterface
{

    /**
     * Saves the log message
     * @param string $message log message
     * @param int $priority priority by syslog
     * @param string $priorityMsg Tag from priority
     */
    public function writeLog(
        string $message,
        int $priority = LOG_DEBUG,
        string $priorityMsg = '[debug]'
    );

}
