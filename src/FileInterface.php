<?php

/**
 * interface "CustomInterface"
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
 * FileInterface
 *
 * @package PhpLogger
 * @author  "Daniel Rendon Arias (ddniel16)" <ddniel16@gmail.com>
 * @license https://opensource.org/licenses/EUPL-1.1 European Union Public Licence (V. 1.1)
 * @version Release: @package_version@
 * @link    https://github.com/ddniel16/php-logger
 */
interface FileInterface
{

    /**
     * Saves the log message
     *
     * @param string $message log message
     * @param string $priority Priority by syslog
     * @param string $priorityMsg Tag from priority
     */
    public function writeLog(
        string $message,
        string $priority = LOG_DEBUG,
        $priorityMsg = '[debug]'
    );

}
