<?php
/**
 * Created by PhpStorm.
 * User: tomten
 * Date: 2015-01-31
 * Time: 12:30
 */

class TestReflector extends PHPUnit_Framework_TestCase {

    public function testClass() {

        require_once __DIR__.'/ExampleClass.php';
        $reflector = new \PHPDocsMD\Reflector('ExampleClass');
        $class = $reflector->getClassEntity();

        $this->assertEquals('ExampleClass', $class->getName());
        $this->assertEquals('This is a description of this class', $class->getDescription());
        $this->assertEquals('Class: Acme\\ExampleClass', $class->generateTitle());
        $this->assertEquals('class-acmeexampleclass', $class->generateAnchor());

        $functions = $class->getFunctions();

        $this->assertEquals('description of a', $functions[0]->getDescription());
        $this->assertEquals(false, $functions[0]->isDeprecated());
        $this->assertEquals('funcA', $functions[0]->getName());
        $this->assertEquals('', $functions[0]->getReturnType());
        $this->assertEquals('public', $functions[0]->getVisibility());

        $this->assertEquals('description of b', $functions[1]->getDescription());
        $this->assertEquals(false, $functions[1]->isDeprecated());
        $this->assertEquals('funcB', $functions[1]->getName());
        $this->assertEquals('', $functions[1]->getReturnType());
        $this->assertEquals('public', $functions[1]->getVisibility());

        $this->assertEquals('description of c', $functions[2]->getDescription());
        $this->assertEquals(true, $functions[2]->isDeprecated());
        $this->assertEquals('funcC', $functions[2]->getName());
        $this->assertEquals('', $functions[2]->getReturnType());
        $this->assertEquals('protected', $functions[2]->getVisibility());

        $this->assertEquals('', $functions[3]->getDescription());
        $this->assertEquals(false, $functions[2]->isDeprecated());
        $this->assertEquals('funcD', $functions[2]->getName());
        $this->assertEquals('void', $functions[2]->getReturnType());
        $this->assertEquals('public', $functions[2]->getVisibility());

        // These function does not declare return type but the return
        // type should be guessable
        $this->assertEquals('bool', $functions[3]->getReturnType());
        $this->assertEquals('bool', $functions[4]->getReturnType());
        $this->assertEquals('mixed', $functions[5]->getReturnType());

        $this->assertTrue( empty($functions[6]) ); // Should be skipped since tagged with @ignore

    }

}
