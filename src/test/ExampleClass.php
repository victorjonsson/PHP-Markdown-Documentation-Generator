<?php
namespace Acme;

/**
 * This is a description
 * of this class
 *
 * @package Acme
 */
abstract class ExampleClass {

    /**
     * Description of a
     * @param $arg
     * @param array $arr
     * @param int $bool
     */
    public function funcA($arg, array $arr, $bool=10) {

    }

    /**
     * Description of c
     * @deprecated This one is deprecated
     * @param $arg
     * @param array $arr
     * @param int $bool
     * @return \Acme\ExampleClass
     */
    protected function funcC($arg, array $arr, $bool=10) {

    }

    /**
     * Description of b
     * @param $arg
     * @param array $arr
     * @param int $bool
     */
    function funcB($arg, array $arr, $bool=10) {

    }

    function funcD($arg, $arr=array()) {

    }

    function getFunc() {}
    function hasFunc() {}
    abstract function isFunc();

    /**
     * @ignore
     */
    function someFunc() {

    }

    private function privFunc() {

    }
}

/**
 * @deprecated This one is deprecated
 *
 * Lorem te ipsum
 *
 * @package Acme
 */
class ExampleClassDepr {

}

interface ExampleInterface {

    public function func($arg='a');

}