<?php

require_once __DIR__.'/../../vendor/autoload.php';


class TestReflector extends PHPUnit_Framework_TestCase {

    /**
     * @var \PHPDocsMD\Reflector
     */
    private $reflector;

    /**
     * @var \PHPDocsMD\ClassEntity
     */
    private $class;

    protected function setUp()
    {
        require_once __DIR__.'/ExampleClass.php';
        $this->reflector = new \PHPDocsMD\Reflector('Acme\\ExampleClass');
        $this->class = $this->reflector->getClassEntity();
    }

    function testClass()
    {
        $this->assertEquals('Acme\\ExampleClass', $this->class->getName());
        $this->assertEquals('This is a description of this class', $this->class->getDescription());
        $this->assertEquals('Class: Acme\\ExampleClass (abstract)', $this->class->generateTitle());
        $this->assertEquals('class-acmeexampleclass', $this->class->generateAnchor());
        $this->assertFalse($this->class->isDeprecated());
        $this->assertFalse($this->class->hasIgnoreTag());

        $refl = new \PHPDocsMD\Reflector('Acme\\ExampleClassDepr');
        $class = $refl->getClassEntity();
        $this->assertTrue($class->isDeprecated());
        $this->assertEquals('This one is deprecated  Lorem te ipsum', $class->getDeprecationMessage());
        $this->assertFalse($class->hasIgnoreTag());

        $refl = new \PHPDocsMD\Reflector('Acme\\ExampleInterface');
        $class = $refl->getClassEntity();
        $this->assertTrue($class->isInterface());
        $this->assertTrue($class->hasIgnoreTag());
    }

    function testFunctions()
    {

        $functions = $this->class->getFunctions();

        $this->assertNotEmpty($functions);

        $this->assertEquals('Description of a', $functions[0]->getDescription());
        $this->assertEquals(false, $functions[0]->isDeprecated());
        $this->assertEquals('funcA', $functions[0]->getName());
        $this->assertEquals('void', $functions[0]->getReturnType());
        $this->assertEquals('public', $functions[0]->getVisibility());

        $this->assertEquals('Description of b', $functions[1]->getDescription());
        $this->assertEquals(false, $functions[1]->isDeprecated());
        $this->assertEquals('funcB', $functions[1]->getName());
        $this->assertEquals('void', $functions[1]->getReturnType());
        $this->assertEquals('public', $functions[1]->getVisibility());

        $this->assertEquals('Description of c', $functions[2]->getDescription());
        $this->assertEquals(true, $functions[2]->isDeprecated());
        $this->assertEquals('This one is deprecated', $functions[2]->getDeprecationMessage());
        $this->assertEquals('funcC', $functions[2]->getName());
        $this->assertEquals('\\Acme\\ExampleClass', $functions[2]->getReturnType());
        $this->assertEquals('protected', $functions[2]->getVisibility());

        $this->assertEquals('', $functions[3]->getDescription());
        $this->assertEquals('funcD', $functions[3]->getName());
        $this->assertEquals('void', $functions[3]->getReturnType());
        $this->assertEquals('public', $functions[3]->getVisibility());
        $this->assertEquals(false, $functions[3]->isDeprecated());

        // These function does not declare return type but the return
        // type should be guessable
        $this->assertEquals('mixed', $functions[4]->getReturnType());
        $this->assertEquals('bool', $functions[5]->getReturnType());
        $this->assertEquals('bool', $functions[6]->getReturnType());
        $this->assertTrue($functions[6]->isAbstract());
        $this->assertTrue($this->class->isAbstract());

        $this->assertTrue( empty($functions[7]) ); // Should be skipped since tagged with @ignore */
    }

    function testParams()
    {
        $paramA = new ReflectionParameter(array('Acme\\ExampleClass', 'funcD'), 2);
        $paramB = new ReflectionParameter(array('Acme\\ExampleClass', 'funcD'), 3);
        $paramC = new ReflectionParameter(array('Acme\\ExampleClass', 'funcD'), 0);

        $typeA = \PHPDocsMD\Reflector::getParamType($paramA);
        $typeB = \PHPDocsMD\Reflector::getParamType($paramB);
        $typeC = \PHPDocsMD\Reflector::getParamType($paramC);

        $this->assertEmpty($typeC);
        $this->assertEquals('\\stdClass', $typeB);
        $this->assertEquals('\\Acme\\ExampleInterface', $typeA);

        $functions = $this->class->getFunctions();
        $params = $functions[3]->getParams();

        $this->assertTrue($functions[3]->hasParams());
        $this->assertFalse($functions[6]->hasParams());
        $this->assertEquals(4, count($params));

        $this->assertEquals(false, $params[0]->getDefault());
        $this->assertEquals('$arg', $params[0]->getName());
        $this->assertEquals('mixed', $params[0]->getType());
        $this->assertEquals('array()', $params[1]->getDefault());
        $this->assertEquals('$arr', $params[1]->getName());
        $this->assertEquals('array', $params[1]->getType());
        $this->assertEquals('null', $params[2]->getDefault());
        $this->assertEquals('$depr', $params[2]->getName());
        $this->assertEquals('\\Acme\\ExampleInterface', $params[2]->getType());
    }
}
