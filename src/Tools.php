<?php

/**
 * Class "Tools"
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
 * Class "Tools"
 *
 * @package PhpLogger
 * @author  "Daniel Rendon Arias (ddniel16)" <ddniel16@gmail.com>
 * @license https://opensource.org/licenses/EUPL-1.1 European Union Public Licence (V. 1.1)
 * @version Release: @package_version@
 * @link    https://github.com/ddniel16/php-logger
 */
class Tools
{

    /**
     * Font colors that recognizes bash
     * @param string $fontColor
     * @return number[]|number
     */
    public function getFontColors($fontColor = false)
    {

        $fontColors = array(
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

        if ($fontColor === false) {
            return $fontColors;
        }

        return $fontColors[$fontColor];

    }

    /**
     * Background colors that recognizes bash
     * @param string $backgroundColor
     * @return number[]|number
     */
    public function getBackgroundColors($backgroundColor = false)
    {

        $backgroundColors = array(
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

        if ($backgroundColor === false) {
            return $backgroundColors;
        }

        return $backgroundColors[$backgroundColor];

    }

    /**
     * @param unknown $fontColor
     * @return number
     */
    public static function checkFontColor($fontColor)
    {


        if (gettype($fontColor) === 'integer') {

            $values = array_values(self::getFontColors());

            if (array_search($fontColor, $values) !== false) {
                return $fontColor;
            }

        } elseif (gettype($fontColor) === 'string') {

            if (array_key_exists($fontColor, self::getFontColors())) {
                return self::getFontColors($fontColor);
            }

        }

        return 39;

    }

    /**
     * @param unknown $backgroundColor
     * @return number
     */
    public static function checkBackgroundColor($backgroundColor)
    {

        if (gettype($backgroundColor) === 'integer') {

            $values = array_values(self::getBackgroundColors());

            if (array_search($backgroundColor, $values) !== false) {
                return $backgroundColor;
            }

        } elseif (gettype($backgroundColor) === 'string') {

            if (
                array_key_exists($backgroundColor, self::getBackgroundColors())
            ) {
                return self::getBackgroundColors($backgroundColor);
            }

        }

        return 49;

    }

    /**
     * Interpolates context values into the message placeholders.
     * @param unknown $message
     * @param array $context
     * @return string
     */
    public static function interpolate(
        $message,
        array $context = array()
    )
    {

        $replace = array();
        foreach ($context as $key => $val) {
            if (
                !is_array($val)
            &&
                (!is_object($val) || method_exists($val, '__toString'))
            ) {
                $replace['{' . trim($key) . '}'] = $val;
            }
        }

        return strtr($message, $replace);

    }

}