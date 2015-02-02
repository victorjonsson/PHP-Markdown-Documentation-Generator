<?php
namespace PHPDocsMD;


/**
 * Class that can create a markdown-formatted table describing class functions
 * referred to via FunctionEntity objects
 *
 * @package PHPDocsMD
 */
class MDTableGenerator {

    /**
     * @var string
     */
    private $md = '';

    /**
     *
     */
    function openTable()
    {
        $this->md = ''; // Clear table
        $this->add('| Visibility | Function |');
        $this->add('|:-----------|:---------|');
    }

    /**
     * @param FunctionEntity $func
     */
    function addFunc(FunctionEntity $func)
    {
        $str = '<strong>';
        if( $func->isAbstract() )
            $str = 'abstract ';

        $str .=  $func->getName().'(';

        if( $func->hasParams() ) {
            $params = array();
            foreach($func->getParams() as $param) {
                $str .= '<em>'.$param->getType().'</em> <strong>'.$param->getName();
                if( $param->getDefault() )
                    $str .= '='.$param->getDefault();
                $str .= '</strong>';
            }
            $str .= '</strong> '.implode(', ', $params) .')';
        } else {
            $str .= ')';
        }

        $str .= '</strong> : <em>'.$func->getReturnType().'</em>';

        if( $func->isDeprecated() ) {
            $str = '<strike>'.$str.'</strike>';
            $str .= '<br />DEPRECATED - '.$func->getDeprecationMessage();
        } elseif( $func->getDescription() ) {
            $str .= '<br />'.$func->getDescription();
        }

        $str = str_replace(array('</strong><strong>', '</strong></strong> '), '', trim($str));

        $this->add('| '.$func->getVisibility().' | '.$str.' |');
    }

    /**
     * @return string
     */
    function getTable()
    {
        return trim($this->md);
    }

    /**
     * @param $str
     */
    private function add($str)
    {
        $this->md .= $str .PHP_EOL;
    }
}