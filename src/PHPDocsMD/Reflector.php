<?php
namespace PHPDocsMD;


/**
 * Object describing a function parameter
 * @package PHPDocsMD
 */
class Reflector {

    /**
     * @var \ReflectionClass
     */
    private $reflection;

    function __construct($className) {
        $this->reflection = new \ReflectionClass($className);
    }

    /**
     * @return \PHPDocsMD\ClassEntity
     */
    function getClassEntity() {
        $class = $this->reflectClass();
        $class->setFunctions($this->reflectFunctions());
        return $class;
    }

    /**
     * @return ClassEntity
     */
    private function reflectClass()
    {

    }

    /**
     * @return FunctionEntity[]
     */
    private function reflectFunctions()
    {

    }
}
