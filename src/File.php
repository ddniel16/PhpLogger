<?php

/**
 * Class "File"
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
 * This class send messages to files
 *
 * @package PhpLogger
 * @author  "Daniel Rendon Arias (ddniel16)" <ddniel16@gmail.com>
 * @license https://opensource.org/licenses/EUPL-1.1 European Union Public Licence (V. 1.1)
 * @version Release: @package_version@
 * @link    https://github.com/ddniel16/php-logger
 */
class File implements FileInterface
{

    /**
     * Options
     *
     * @var array
     */
    protected $_options;

    /**
     * Merge options with default options
     *
     * @param array $options
     */
    public function __construct(array $options = array())
    {

       $default = array(
            'logDir' => sys_get_temp_dir(),
            'name' => 'php-logger',
            'ext' => 'log',
            'dateFormat' => 'd-m-Y H:i:s P',
            'maxLogs' => 1,
            'maxSize' => 123123154
        );

       $this->_options = array_merge($default, $options);

    }

    /**
     * Saves the log message
     *
     * {@inheritDoc}
     * @see \PhpLogger\FileInterface::writeLog()
     */
    public function writeLog(
        string $message,
        string $status = '[debug]',
        $priority = LOG_DEBUG
    )
    {

        $logMaxSize = $this->getOption('maxSize');
        if (!is_numeric($logMaxSize)) {
            $logMaxSize = 104857600;
        }

        $logFile = sprintf(
            '%s/%s.%s',
            $this->getOption('logDir'),
            $this->getOption('name'),
            $this->getOption('ext')
        );

        if (!file_exists($logFile)) {
            $log = fopen($logFile, 'w');
            fclose($log);
        }

        $fileSize = filesize($logFile);

        if ($fileSize > $logMaxSize) {

            $numFile = sizeof($this->getFiles()) + 1;

            if ($numFile <= $this->getOption('maxLogs')) {

                $pathInfo = pathinfo($logFile);
                $newName = sprintf(
                    '%s.%s.%s',
                    $pathInfo['filename'],
                    $numFile,
                    $pathInfo['extension']
                );

                rename(
                    $logFile,
                    $this->getOption('logDir') . '/' . $newName
                );

                $log = fopen($logFile, 'w');
                fclose($log);

            }
        }

        $date = date($this->getOption('dateFormat'));

        file_put_contents(
            $logFile,
            $date . ': ' . $status . ' ' . print_r($message, true) . PHP_EOL,
            FILE_APPEND | LOCK_EX
        );

    }

    /**
     * get option value
     *
     * @param  string $option
     * @return string option value
     */
    public function getOption(string $option)
    {
        return $this->_options[$option];
    }

    /**
     * get current files
     *
     * @return array
     */
    public function getFiles()
    {

        $files = array();
        $listFiles = scandir($this->getOption('logDir'));

        if (!empty($listFiles)) {
            foreach ($listFiles as $file) {
                $info = pathinfo($file);
                if (
                    isset($info['extension'])
                &&
                    $info['extension'] === $this->getOption('ext')
                ) {
                    $files[] = $file;
                }

            }
        }

        return $files;

    }

}