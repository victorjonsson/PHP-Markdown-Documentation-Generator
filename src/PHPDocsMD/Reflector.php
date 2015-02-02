<?php
namespace PHPDocsMD;


/**
 * Class that can compute ClassEntity objects out of real classes
 * @package PHPDocsMD
 */
class Reflector {

    /**
     * @var string
     */
    private $className;

    /**
     * @param string $className
     */
    function __construct($className) {
        $this->className = $className;
    }

    /**
     * @return \PHPDocsMD\ClassEntity
     */
    function getClassEntity() {
        $classReflection = new \ReflectionClass($this->className);
        $class = new ClassEntity();
        $classTags = $this->createEntity($classReflection, $class);

        $class->isInterface($classReflection->isInterface());
        $class->isAbstract($classReflection->isAbstract());
        $class->hasIgnoreTag( isset($classTags['ignore']) );
        if( $classReflection->getParentClass() ) {
            $class->setExtends($classReflection->getParentClass()->getName());
        }

        $functions = array();
        foreach($classReflection->getMethods() as $methodReflection) {
            $func = new FunctionEntity();
            $tags = $this->createEntity($methodReflection, $func);

            if( $this->shouldIgnoreMethod($tags, $methodReflection, $class) ) {
                continue;
            }

            $params = array();
            foreach($methodReflection->getParameters() as $param) {
                $docs = isset($tags['params'][$param->getName()]) ? $tags['params'][$param->getName()] : array();
                $params[$param->getName()] = $this->createParameterEntity($param, $docs);
            }

            if( empty($tags['return']) ) {
                $tags['return'] = $this->guessReturnTypeFromFuncName($func->getName());
            }

            $func->setReturnType($tags['return']);
            $func->setParams(array_values($params));
            $func->setVisibility( $methodReflection->isPublic() ? 'public':'protected');

            if( $methodReflection->isAbstract() ) {
                $func->isAbstract(true);
            }

            $functions[$func->getName()] =  $func;
        }
        ksort($functions);
        $class->setFunctions(array_values($functions));

        return $class;
    }

    /**
     * @param array $tags
     * @param \ReflectionMethod $methodReflection
     * @param ClassEntity $class
     * @return bool
     */
    private function shouldIgnoreMethod($tags, $methodReflection, $class)
    {
        return isset($tags['ignore']) ||
                $methodReflection->isPrivate() ||
                $methodReflection->getDeclaringClass()->getName() != $class->getName();
    }

    /**
     * @param \ReflectionParameter $reflection
     * @param array $docs
     * @return FunctionEntity
     */
    private function createParameterEntity($reflection, $docs)
    {
        // need to use slash instead of pipe or md-generation will get it wrong

        $def = false;
        $type = 'mixed';
        $docs['type'] = empty($docs['type']) ? $this->getParamType($reflection) : $docs['type'].'/'.$this->getParamType($reflection);

        try {
            $def = $reflection->getDefaultValue();
            $type = $this->getTypeFromVal($def);
            if( is_string($def) ) {
                $def = "'$def'";
            } elseif( is_bool($def) ) {
                $def = $def ? 'true':'false';
            } elseif( is_null($def) ) {
                $def = 'null';
            } elseif( is_array($def) ) {
                $def = 'array()';
            }
        } catch(\Exception $e) {}

        $varName = '$'.$reflection->getName();

        if( !empty($docs) ) {
            $docs['default'] = $def;
            if( $type == 'mixed' && $def == 'null' && strpos($docs['type'], '\\') === 0 ) {
                $type = false;
            }
            if( $type && $def && !empty($docs['type']) && $docs['type'] != $type ) {
                $docs['type'] = $type.'/'.$docs['type'];
            } elseif( $type && empty($docs['type']) ) {
                $docs['type'] = $type;
            }
        } else {
            $docs = array(
                'descriptions'=>'',
                'name' => $varName,
                'default' => $def
            );
        }

        $param = new ParamEntity();
        $param->setDescription($docs['description']);
        $param->setName($varName);
        $param->setDefault($docs['default']);
        $param->setType(empty($docs['type']) ? 'mixed':$docs['type']);
        return $param;
    }

    function getParamType(\ReflectionParameter $refParam)
    {

        $export = \ReflectionParameter::export(
            array(
                $refParam->getDeclaringClass()->name,
                $refParam->getDeclaringFunction()->name
            ),
            $refParam->name,
            true
        );

        $export =  str_replace(' or NULL', '', $export);

        $type = preg_replace('/.*?([\w\\\]+)\s+\$'.current(explode('=', $refParam->name)).'.*/', '\\1', $export);
        if( strpos($type, 'Parameter ') !== false ) {
            return '';
        }

        if( $type != 'array' && strpos($type, '\\') !== 0 ) {
            $type = '\\'.$type;
        }

        return $type;
    }

    /**
     * @param string $name
     * @return string
     */
    private function guessReturnTypeFromFuncName($name)
    {
        $mixed = array('get', 'load', 'fetch', 'find', 'create');
        $bool = array('is', 'can', 'has', 'have', 'should');
        foreach($mixed as $prefix) {
            if( strpos($name, $prefix) === 0 )
                return 'mixed';
        }
        foreach($bool as $prefix) {
            if( strpos($name, $prefix) === 0 )
                return 'bool';
        }
        return 'void';
    }

    /**
     * @param string $def
     * @return string
     */
    private function getTypeFromVal($def)
    {
        if( is_string($def) ) {
            return 'string';
        } elseif( is_bool($def) ) {
            return 'bool';
        } elseif( is_array($def) ) {
            return 'array';
        } else {
            return 'mixed';
        }
    }

    /**
     * @param \ReflectionClass|\ReflectionMethod $reflection
     * @param CodeEntity $class
     * @return array
     */
    private function createEntity($reflection, $class)
    {
        $comment = $this->getCleanDocComment($reflection);
        $tags = $this->extractTagsFromComment($comment);
        $class->setName($reflection->getName());
        $class->setDescription($tags['description']);
        if( $tags['deprecated'] ) {
            $class->isDeprecated(true);
            $class->setDeprecationMessage($tags['deprecated']);
        }
        return $tags;
    }

    /**
     * @param \ReflectionClass $reflection
     * @return string
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

        foreach($tags as $name => $val) {
            if( is_array($val) ) {
                foreach($val as $subName=>$subVal) {
                    if( is_string($subVal) )
                        $tags[$name][$subName] = trim($subVal);
                }
            } else {
                $tags[$name] = trim($val);
            }
        }

        return $tags;
    }
}
