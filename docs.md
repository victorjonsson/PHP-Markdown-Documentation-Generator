## Table of contents

- [\PHPDocsMD\ClassEntity](#class-phpdocsmdclassentity)
- [\PHPDocsMD\CodeEntity](#class-phpdocsmdcodeentity)
- [\PHPDocsMD\FunctionEntity](#class-phpdocsmdfunctionentity)
- [\PHPDocsMD\MDTableGenerator](#class-phpdocsmdmdtablegenerator)
- [\PHPDocsMD\ParamEntity](#class-phpdocsmdparamentity)
- [\PHPDocsMD\Reflector](#class-phpdocsmdreflector)
- [\PHPDocsMD\ReflectorInterface (interface)](#interface-phpdocsmdreflectorinterface)
- [\PHPDocsMD\Console\CLI](#class-phpdocsmdconsolecli)
- [\PHPDocsMD\Console\PHPDocsMDCommand](#class-phpdocsmdconsolephpdocsmdcommand)

<hr /> 
### Class: \PHPDocsMD\ClassEntity

> Object describing a class or a interface



*This class extends [\PHPDocsMD\CodeEntity](#class-phpdocsmdcodeentity)*

<hr /> 
### Class: \PHPDocsMD\CodeEntity

> Object describing a piece of code



<hr /> 
### Class: \PHPDocsMD\FunctionEntity

> Object describing a function



*This class extends [\PHPDocsMD\CodeEntity](#class-phpdocsmdcodeentity)*

<hr /> 
### Class: \PHPDocsMD\MDTableGenerator

> Class that can create a markdown-formatted table describing class functions referred to via FunctionEntity objects

###### Example
```php
<?php
      $generator = new PHPDocs\\MDTableGenerator();
      $generator->openTable();
      foreach($classEntity->getFunctions() as $func)
          $generator->addFunc( $func );
 
      echo $generator->getTable();
````



<hr /> 
### Class: \PHPDocsMD\ParamEntity

> Object describing a function parameter



*This class extends [\PHPDocsMD\CodeEntity](#class-phpdocsmdcodeentity)*

<hr /> 
### Class: \PHPDocsMD\Reflector

> Class that can compute ClassEntity objects out of real classes

<<<<<<< HEAD

=======
| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>string</em> <strong>$className</strong>)</strong> : <em>void</em> |
| public | <strong>getClassEntity()</strong> : <em>[\PHPDocsMD\ClassEntity](#class-phpdocsmdclassentity)</em> |
| public static |  <strong>aFunc()</strong> : <em>[\PHPDocsMD\ClassEntity](#class-phpdocsmdclassentity)</em>
```php
<?php
           $reflector = new \\ReflectionClass('MyClass');
           foreach($reflector->getMethods() as $method ) {
               foreach($method->getParameters() as $param) {
                   $name = $param->getName();
                   $type = Reflector::getParamType($param);
                   printf("%s = %s\n", $name, $type);
               }
           }
```
|
| protected | <strong>createClassEntity(</strong><em>\ReflectionClass</em> <strong>$reflection</strong>)</strong> : <em>[\PHPDocsMD\ClassEntity](#class-phpdocsmdclassentity)</em> |
| protected | <strong>createFunctionEntity(</strong><em>\ReflectionMethod</em> <strong>$method</strong>, <em>[\PHPDocsMD\ClassEntity](#class-phpdocsmdclassentity)</em> <strong>$class</strong>)</strong> : <em>bool/[\PHPDocsMD\FunctionEntity](#class-phpdocsmdfunctionentity)</em> |
| protected | <strong>shouldIgnoreFunction(</strong><em>array</em> <strong>$tags</strong>, <em>\ReflectionMethod</em> <strong>$method</strong>, <em>[\PHPDocsMD\ClassEntity](#class-phpdocsmdclassentity)</em> <strong>$class</strong>)</strong> : <em>bool</em> |
>>>>>>> 58ca8b42569881c6b69bf87b8b5e482212e045e5

*This class implements [\PHPDocsMD\ReflectorInterface](#interface-phpdocsmdreflectorinterface)*

<hr /> 
### Interface: \PHPDocsMD\ReflectorInterface

> Interface for classes that can compute ClassEntity objects



<hr /> 
### Class: \PHPDocsMD\Console\CLI

> Command line interface used to extract markdown-formatted documentation from classes



*This class extends \Symfony\Component\Console\Application*

<hr /> 
### Class: \PHPDocsMD\Console\PHPDocsMDCommand

> Console command used to extract markdown-formatted documentation from classes



*This class extends \Symfony\Component\Console\Command\Command*

