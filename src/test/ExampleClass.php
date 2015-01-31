<?php
namespace Acme;

/**
 * This is a description
 * of this class
 *
 * @package Acme
 */
class ExampleClass {

    /**
     * Description of funcA
     * @param $arg
     * @param array $arr
     * @param int $bool
     */
    public function funcA($arg, array $arr, $bool=10) {

    }

    /**
     * Description of funcC
     * @deprecated This on is deprecated
     * @param $arg
     * @param array $arr
     * @param int $bool
     */
    protected function funcC($arg, array $arr, $bool=10) {

    }

    /**
     * Description of funcB
     * @param $arg
     * @param array $arr
     * @param int $bool
     */
    function funcB($arg, array $arr, $bool=10) {

    }

    function funcD($arg, $arr=array()) {

    }

    function isFunc() {}
    function hasFunc() {}
    function getFunc() {}

    /**
     * @ignore
     */
    function somFunc() {

    }
}