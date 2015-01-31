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

    /**
     * @param string $className
     */
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
        $class = new ClassEntity();
        $comment = $this->getCleanDocComment($this->reflection);
        $tags = $this->extractTagsFromComment($comment);
        $class->setName($this->reflection->getName());
        $class->setDescription($tags['description']);
        if( $tags['deprecated'] ) {
            $class->isDeprecated(true);
            $class->setDeprecationMessage($tags['deprecated']);
        }
        return $class;
    }

    /**
     * @return FunctionEntity[]
     */
    private function reflectFunctions()
    {
        return array();
    }

    /**
     * @param \ReflectionClass $reflection
     */
    private function getCleanDocComment($reflection)
    {
        $comment = str_replace(array('/*', '*/'), '', $reflection->getDocComment());
        return trim(str_replace('*', '', $comment));
    }

    /**
     * @param string $comment
     * @param string $current_tag
     * @return array
     */
    private function extractTagsFromComment($comment, $current_tag='description')
    {
        $tags = array($current_tag=>'');
        foreach(explode(PHP_EOL, $comment) as $line) {
            $line = trim($line);
            if( empty($current) ) {
                $words = explode(' ', $line);
                if( strpos($words[0], '@') === false ) {
                    $tags[$current_tag] .= ' '. $line;
                } elseif( $words[0] == '@param' ) {
                    array_splice($words, 0, 1);
                    $param_desc = '';
                    if( strpos($words[0], '$') === 0) {
                        $param_name = $words[0];
                        $param_type = 'mixed';
                        array_splice($words, 0, 1);
                    } else {
                        $param_name = $words[1];
                        $param_type = $words[0];
                        array_splice($words, 0, 2);
                    }
                    $param_name = current(explode('=', $param_name));
                    if( count($words) > 1 ) {
                        $param_desc = join(' ', $words);
                    }
                    $tags['params'][$param_name] = array(
                        'description' => $param_desc,
                        'name' => $param_name,
                        'type' => $param_type,
                        'default' => false
                    );
                } else {
                    $current_tag = substr($words[0], 1);
                    array_splice($words, 0 ,1);
                    if( empty($tags[$current_tag]) ) {
                        $tags[$current_tag] = '';
                    }
                    $tags[$current_tag] .= trim(join(' ', $words));
                }
            }
        }

        foreach($tags as $name => $val) {
            $tags[$name] = trim($val);
        }

        return $tags;
    }
}
