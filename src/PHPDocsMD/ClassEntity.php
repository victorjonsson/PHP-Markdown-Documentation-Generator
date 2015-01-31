<?php
namespace PHPDocsMD;


/**
 * Object describing a function
 * @package PHPDocsMD
 */
class ClassEntity {

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var string
     */
    private $description = '';

    /**
     * @var \PHPDocsMD\FunctionEntity[]
     */
    private $functions = array();

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

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
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
