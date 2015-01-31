<?php
namespace PHPDocsMD;


/**
 * Object describing a function parameter
 * @package PHPDocsMD
 */
class ParamEntity {

    /**
     * @var string
     */
    private $description = '';

    /**
     * @var bool
     */
    private $default=false;

    /**
     * @var string
     */
    private $type='mixed';

    /**
     * @param boolean $default
     */
    public function setDefault($default)
    {
        $this->default = $default;
    }

    /**
     * @return boolean
     */
    public function getDefault()
    {
        return $this->default;
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
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}

