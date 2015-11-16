<?php
namespace PHPDocsMD;

/**
 * @package PHPDocsMD
 */
class Utils
{

    /**
     * @param string $name
     * @return string
     */
    public static function sanitizeClassName($name)
    {
        return '\\'.trim($name, ' \\');
    }

    /**
     * @param string $fullClassName
     * @return string
     */
    public static function getClassBaseName($fullClassName)
    {
        $parts = explode('\\', trim($fullClassName));
        return end($parts);
    }

}