<?php
namespace PHPDocsMD;


/**
 * Object describing a piece of code
 * @package PHPDocsMD
 */
class CodeEntity {

    /**
     * @var string
     */
    private $name='';

    /**
     * @var string
     */
    private $description = '';

    /**
     * @var bool
     */
    private $isDeprecated = false;


    /**
     * @param bool|null $toggle
     * @return bool|void
     */
    public function isDeprecated($toggle=null)
    {
        if( $toggle === null ) {
            return $this->isDeprecated;
        } else {
            $this->isDeprecated = (bool)$toggle;
        }
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

}