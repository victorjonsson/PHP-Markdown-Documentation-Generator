<?php
namespace PHPDocsMD;


/**
 * Interface for classes that can compute ClassEntity objects
 * @package PHPDocsMD
 */
interface ReflectorInterface
{
    /**
     * Get declared type of a parameter. Will return empty string if not
     * @param \ReflectionParameter $refParam
     * @return string
     */
    function getParamType(\ReflectionParameter $refParam);

    /**
     * @return \PHPDocsMD\ClassEntity
     */
    function getClassEntity();
}