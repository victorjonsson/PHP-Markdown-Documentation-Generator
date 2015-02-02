<?php
namespace PHPDocsMD;


/**
 * Object describing a class or a interface
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
     * @var bool
     */
    private $hasIgnoreTag = false;

    /**
     * @var string
     */
    private $extends = '';

    /**
     * @var array
     */
    private $interfaces = array();


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

    public function hasIgnoreTag($toggle=null)
    {
        if( $toggle === null ) {
            return $this->hasIgnoreTag;
        } else {
            $this->hasIgnoreTag = (bool)$toggle;
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
     * @param string $extends
     */
    public function setExtends($extends)
    {
        $this->extends = $extends;
    }

    /**
     * @return string
     */
    public function getExtends()
    {
        return $this->extends;
    }

    /**
     * @param \PHPDocsMD\FunctionEntity[] $functions
     */
    public function setFunctions(array $functions)
    {
        $this->functions = $functions;
    }

    /**
     * @param array $implements
     */
    public function setInterfaces(array $implements)
    {
        $this->interfaces = $implements;
    }

    /**
     * @return array
     */
    public function getInterfaces()
    {
        return $this->interfaces;
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
        $label = $this->isInterface() ? 'Interface' : 'Class';
        $abstractTag = $this->isAbstract() && !$this->isInterface() ? ' (abstract)' : '';
        return $label .': '. $this->getName() .$abstractTag;
    }

    /**
     * @return string
     */
    function generateAnchor() {
        $title = current(explode(' (', $this->generateTitle()));
        return strtolower(str_replace(array(':', ' ', '\\'), array('', '-', ''), $title));
    }
}
