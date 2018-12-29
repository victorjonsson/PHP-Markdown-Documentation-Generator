<?php
namespace PHPDocsMD;


/**
 * Object describing a class or an interface
 * @package PHPDocsMD
 */
class ClassEntity extends CodeEntity {

    /**
     * @var \PHPDocsMD\FunctionEntity[]
     */
    private $functions = [];

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
     * @var bool
     */
    private $hasInternalTag = false;

    /**
     * @var string
     */
    private $extends = '';

    /**
     * @var array
     */
    private $interfaces = [];

    /**
     * @var array
     */
    private $see = [];

    /**
     * @var bool
     */
    private $isNative;

    /**
     * @param bool $toggle
     * @return bool
     */
    public function isAbstract($toggle=null)
    {
        if ( $toggle === null ) {
            return $this->abstract;
        } else {
            return $this->abstract = (bool)$toggle;
        }
    }

    /**
     * @param bool $toggle
     * @return bool
     */
    public function hasIgnoreTag($toggle=null)
    {
        if( $toggle === null ) {
            return $this->hasIgnoreTag;
        } else {
            return $this->hasIgnoreTag = (bool)$toggle;
        }
    }

    /**
     * @param bool $toggle
     * @return bool
     */
    public function hasInternalTag($toggle = null)
    {
        if ($toggle === null) {
            return $this->hasInternalTag;
        } else {
            return $this->hasInternalTag = (bool)$toggle;
        }
    }

    /**
     * @param bool $toggle
     * @return bool
     */
    public function isInterface($toggle=null)
    {
        if( $toggle === null ) {
            return $this->isInterface;
        } else {
            return $this->isInterface = (bool)$toggle;
        }
    }

    /**
     * @param bool $toggle
     * @return bool
     */
    public function isNative($toggle=null)
    {
        if( $toggle === null ) {
            return $this->isNative;
        } else {
            return $this->isNative = (bool)$toggle;
        }
    }

    /**
     * @param string $extends
     */
    public function setExtends($extends)
    {
        $this->extends = Utils::sanitizeClassName($extends);
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
     * @param array $see
     */
    public function setSee(array $see)
    {
        $this->see = [];
        foreach($see as $i) {
            $this->see[] = $i;
        }
    }

    /**
     * @param array $implements
     */
    public function setInterfaces(array $implements)
    {
        $this->interfaces = [];
        foreach($implements as $interface) {
            $this->interfaces[] = Utils::sanitizeClassName($interface);
        }
    }

    /**
     * @return array
     */
    public function getInterfaces()
    {
        return $this->interfaces;
    }

    /**
     * @return array
     */
    public function getSee()
    {
        return $this->see;
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
    function setName($name)
    {
        parent::setName(Utils::sanitizeClassName($name));
    }

    /**
     * Check whether this object is referring to given class name or object instance
     * @param string|object $class
     * @return bool
     */
    function isSame($class)
    {
        $className = is_object($class) ? get_class($class) : $class;
        return Utils::sanitizeClassName($className) == $this->getName();
    }

    /**
     * Generate a title describing the class this object is referring to
     * @param string $format
     * @return string
     */
    function generateTitle($format='%label%: %name% %extra%')
    {
        $translate = [
            '%label%' => $this->isInterface() ? 'Interface' : 'Class',
            '%name%' => substr_count($this->getName(), '\\') == 1 ? substr($this->getName(), 1) : $this->getName(),
            '%extra%' => ''
        ];

        if( strpos($format, '%label%') === false ) {
            if( $this->isInterface() )
                $translate['%extra%'] = '(interface)';
            elseif( $this->isAbstract() )
                $translate['%extra%'] = '(abstract)';
        } else {
            $translate['%extra%'] = $this->isAbstract() && !$this->isInterface() ? '(abstract)' : '';
        }

        return trim(strtr($format, $translate));
    }

    /**
     * Generates an anchor link out of the generated title (see generateTitle)
     * @return string
     */
    function generateAnchor()
    {
        $title = $this->generateTitle();
        return strtolower(str_replace([':', ' ', '\\', '(', ')'], ['', '-', '', '', ''], $title));
    }
}
