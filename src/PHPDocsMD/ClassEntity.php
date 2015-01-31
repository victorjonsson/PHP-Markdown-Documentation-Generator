<?php
namespace PHPDocsMD;


/**
 * Object describing a class
 * @package PHPDocsMD
 */
class ClassEntity extends CodeEntity {

    /**
     * @var \PHPDocsMD\FunctionEntity[]
     */
    private $functions = array();

    /**
     * @param \PHPDocsMD\FunctionEntity[] $functions
     */
    public function setFunctions(array $functions)
    {
        $this->functions = $functions;
    }

    /**
     * @return \PHPDocsMD\FunctionEntity[]
     */
    public function getFunctions()
    {
        return $this->functions;
    }

    /**
     * @return string
     */
    function generateTitle() {
        return 'Class: '.$this->getName();
    }

    /**
     * @return string
     */
    function generateAnchor() {
        return strtolower(str_replace(array(':', ' ', '\\'), array('', '-', ''), $this->generateTitle()));
    }
}
