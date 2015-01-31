<?php
namespace PHPDocsMD;


/**
 * Object describing a function
 * @package PHPDocsMD
 */
class FunctionEntity {

    /**
     * @var string
     */
    private $description = '';

    /**
     * @var \PHPDocsMD\ParamEntity[]
     */
    private $params = array();

    /**
     * @var string
     */
    private $returnType = 'void';

    /**
     * @var string
     */
    private $name = '';

    /**
     * @var string
     */
    private $visibility = 'public';

    /**
     * @var bool
     */
    private $deprecated = false;

    /**
     * @param boolean $deprecated
     */
    public function setDeprecated($deprecated)
    {
        $this->deprecated = $deprecated;
    }

    /**
     * @return boolean
     */
    public function getDeprecated()
    {
        return $this->deprecated;
    }

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
     * @param \PHPDocsMD\ParamEntity[] $params
     */
    public function setParams(array $params)
    {
        $this->params = $params;
    }

    /**
     * @return \PHPDocsMD\ParamEntity[]
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @param string $returnType
     */
    public function setReturnType($returnType)
    {
        $this->returnType = $returnType;
    }

    /**
     * @return string
     */
    public function getReturnType()
    {
        return $this->returnType;
    }

    /**
     * @param string $visibility
     */
    public function setVisibility($visibility)
    {
        $this->visibility = $visibility;
    }

    /**
     * @return string
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

}

