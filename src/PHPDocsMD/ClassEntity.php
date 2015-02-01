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
     * @var bool
     */
    private $isInterface = false;

    /**
     * @var bool
     */
    private $abstract = false;


    /**
     * @param null|bool $toggle
     */
    public function isAbstract($toggle=null)
    {
        if ( $toggle === null ) {
            return $this->abstract;
        } else {
            $this->abstract = (bool)$toggle;
        }
    }

    /**
     * @param null|bool $toggle
     * @return bool
     */
    public function isInterface($toggle=null)
    {
        if( $toggle === null ) {
            return $this->isInterface;
        } else {
            $this->isInterface = (bool)$toggle;
        }
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
     * @return string
     */
    function generateTitle() {
        return ($this->isInterface() ? 'Interface' : 'Class') .': '. $this->getName();
    }

    /**
     * @return string
     */
    function generateAnchor() {
        return strtolower(str_replace(array(':', ' ', '\\'), array('', '-', ''), $this->generateTitle()));
    }
}
