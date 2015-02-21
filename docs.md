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

