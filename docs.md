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

| Visibility | Function |
|:-----------|:---------|
| public | <strong>generateAnchor()</strong> : <em>string</em><br /><em>Generates an anchor link out of the generated title (see generateTitle)</em> |
| public | <strong>generateTitle(</strong><em>string</em> <strong>$format=`'%label%: %name% %extra%'`</strong>)</strong> : <em>string</em><br /><em>Generate a title describing the class this object is referring to</em> |
| public | <strong>getExtends()</strong> : <em>string</em> |
| public | <strong>getFunctions()</strong> : <em>[\PHPDocsMD\FunctionEntity](#class-phpdocsmdfunctionentity)[]</em> |
| public | <strong>getInterfaces()</strong> : <em>array</em> |
| public | <strong>hasIgnoreTag(</strong><em>mixed/null/bool</em> <strong>$toggle=null</strong>)</strong> : <em>bool</em> |
| public | <strong>isAbstract(</strong><em>mixed/null/bool</em> <strong>$toggle=null</strong>)</strong> : <em>bool</em> |
| public | <strong>isInterface(</strong><em>mixed/null/bool</em> <strong>$toggle=null</strong>)</strong> : <em>bool</em> |
| public | <strong>isSame(</strong><em>string/object</em> <strong>$class</strong>)</strong> : <em>bool</em><br /><em>Check whether this object is referring to given class name or object instance</em> |
| public static | <strong>sanitizeClassName(</strong><em>string</em> <strong>$name</strong>)</strong> : <em>string</em> |
| public | <strong>setExtends(</strong><em>string</em> <strong>$extends</strong>)</strong> : <em>void</em> |
| public | <strong>setFunctions(</strong><em>[\PHPDocsMD\FunctionEntity](#class-phpdocsmdfunctionentity)[]</em> <strong>$functions</strong>)</strong> : <em>void</em> |
| public | <strong>setInterfaces(</strong><em>array</em> <strong>$implements</strong>)</strong> : <em>void</em> |
| public | <strong>setName(</strong><em>string</em> <strong>$name</strong>)</strong> : <em>void</em> |

*This class extends [\PHPDocsMD\CodeEntity](#class-phpdocsmdcodeentity)*

<hr /> 
### Class: \PHPDocsMD\CodeEntity

> Object describing a piece of code

| Visibility | Function |
|:-----------|:---------|
| public | <strong>getDeprecationMessage()</strong> : <em>string</em> |
| public | <strong>getDescription()</strong> : <em>string</em> |
| public | <strong>getExample()</strong> : <em>string</em> |
| public | <strong>getName()</strong> : <em>string</em> |
| public | <strong>isDeprecated(</strong><em>mixed/bool/null</em> <strong>$toggle=null</strong>)</strong> : <em>void/bool</em> |
| public | <strong>setDeprecationMessage(</strong><em>string</em> <strong>$deprecationMessage</strong>)</strong> : <em>void</em> |
| public | <strong>setDescription(</strong><em>string</em> <strong>$description</strong>)</strong> : <em>void</em> |
| public | <strong>setExample(</strong><em>string</em> <strong>$example</strong>)</strong> : <em>void</em> |
| public | <strong>setName(</strong><em>string</em> <strong>$name</strong>)</strong> : <em>void</em> |

<hr /> 
### Class: \PHPDocsMD\FunctionEntity

> Object describing a function

| Visibility | Function |
|:-----------|:---------|
| public | <strong>getParams()</strong> : <em>[\PHPDocsMD\ParamEntity](#class-phpdocsmdparamentity)[]</em> |
| public | <strong>getReturnType()</strong> : <em>string</em> |
| public | <strong>getVisibility()</strong> : <em>string</em> |
| public | <strong>hasParams()</strong> : <em>bool</em> |
| public | <strong>isAbstract(</strong><em>mixed/null/bool</em> <strong>$toggle=null</strong>)</strong> : <em>bool</em> |
| public | <strong>isStatic(</strong><em>mixed/null/bool</em> <strong>$toggle=null</strong>)</strong> : <em>bool</em> |
| public | <strong>setParams(</strong><em>[\PHPDocsMD\ParamEntity](#class-phpdocsmdparamentity)[]</em> <strong>$params</strong>)</strong> : <em>void</em> |
| public | <strong>setReturnType(</strong><em>string</em> <strong>$returnType</strong>)</strong> : <em>void</em> |
| public | <strong>setVisibility(</strong><em>string</em> <strong>$visibility</strong>)</strong> : <em>void</em> |

*This class extends [\PHPDocsMD\CodeEntity](#class-phpdocsmdcodeentity)*

<hr /> 
### Class: \PHPDocsMD\MDTableGenerator

> Class that can create a markdown-formatted table describing class functions referred to via FunctionEntity objects

###### Example
```php
<?php
     $generator = new PHPDocs\\MDTableGenerator();
     $generator->openTable();
     foreach($classEntity->getFunctions() as $func) {
  $generator->addFunc( $func );
     }
     echo $generator->getTable();
````

| Visibility | Function |
|:-----------|:---------|
| public | <strong>addFunc(</strong><em>[\PHPDocsMD\FunctionEntity](#class-phpdocsmdfunctionentity)</em> <strong>$func</strong>)</strong> : <em>string</em><br /><em>Generates a markdown formatted table row with information about given function. Then adds the row to the table and returns the markdown formatted string.</em> |
| public | <strong>appendExamplesToEndOfTable(</strong><em>bool</em> <strong>$toggle</strong>)</strong> : <em>void</em><br /><em>All example comments found while generating the table will be appended to the end of the table. Set $toggle to false to prevent this behaviour</em> |
| public static | <strong>formatExampleComment(</strong><em>string</em> <strong>$example</strong>)</strong> : <em>string</em><br /><em>Create a markdown-formatted code view out of an example comment</em> |
| public | <strong>getTable()</strong> : <em>string</em> |
| public | <strong>openTable()</strong> : <em>void</em><br /><em>St</em> |

<hr /> 
### Class: \PHPDocsMD\ParamEntity

> Object describing a function parameter

| Visibility | Function |
|:-----------|:---------|
| public | <strong>getDefault()</strong> : <em>boolean</em> |
| public | <strong>getType()</strong> : <em>string</em> |
| public | <strong>setDefault(</strong><em>boolean</em> <strong>$default</strong>)</strong> : <em>void</em> |
| public | <strong>setType(</strong><em>string</em> <strong>$type</strong>)</strong> : <em>void</em> |

*This class extends [\PHPDocsMD\CodeEntity](#class-phpdocsmdcodeentity)*

<hr /> 
### Class: \PHPDocsMD\Reflector

> Class that can compute ClassEntity objects out of real classes

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>string</em> <strong>$className</strong>)</strong> : <em>void</em> |
| public | <strong>getClassEntity()</strong> : <em>[\PHPDocsMD\ClassEntity](#class-phpdocsmdclassentity)</em> |
| public static | <strong>getParamType(</strong><em>\ReflectionParameter</em> <strong>$refParam</strong>)</strong> : <em>string</em><br /><em>Tries to find out if the type of the given parameter. Will return empty string if not possible.</em> |
| protected | <strong>createClassEntity(</strong><em>\ReflectionClass</em> <strong>$reflection</strong>)</strong> : <em>[\PHPDocsMD\ClassEntity](#class-phpdocsmdclassentity)</em> |
| protected | <strong>createFunctionEntity(</strong><em>\ReflectionMethod</em> <strong>$method</strong>, <em>[\PHPDocsMD\ClassEntity](#class-phpdocsmdclassentity)</em> <strong>$class</strong>)</strong> : <em>bool/[\PHPDocsMD\FunctionEntity](#class-phpdocsmdfunctionentity)</em> |
| protected | <strong>shouldIgnoreFunction(</strong><em>array</em> <strong>$tags</strong>, <em>\ReflectionMethod</em> <strong>$method</strong>, <em>[\PHPDocsMD\ClassEntity](#class-phpdocsmdclassentity)</em> <strong>$class</strong>)</strong> : <em>bool</em> |
#### Examples of getParamType
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
````

*This class implements [\PHPDocsMD\ReflectorInterface](#interface-phpdocsmdreflectorinterface)*

<hr /> 
### Interface: \PHPDocsMD\ReflectorInterface

> Interface for classes that can compute ClassEntity objects

| Visibility | Function |
|:-----------|:---------|
| public | <strong>abstract getClassEntity()</strong> : <em>[\PHPDocsMD\ClassEntity](#class-phpdocsmdclassentity)</em> |

<hr /> 
### Class: \PHPDocsMD\Console\CLI

> Command line interface used to extract markdown-formatted documentation from classes

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct()</strong> : <em>void</em> |
| public | <strong>run(</strong><em>\Symfony\Component\Console\Input\InputInterface</em> <strong>$input=null</strong>, <em>\Symfony\Component\Console\Output\OutputInterface</em> <strong>$output=null</strong>)</strong> : <em>int</em> |

*This class extends \Symfony\Component\Console\Application*

<hr /> 
### Class: \PHPDocsMD\Console\PHPDocsMDCommand

> Console command used to extract markdown-formatted documentation from classes

| Visibility | Function |
|:-----------|:---------|
| public | <strong>extractClassNameFromLine(</strong><em>string</em> <strong>$type</strong>, <em>string</em> <strong>$line</strong>)</strong> : <em>string</em> |
| protected | <strong>configure()</strong> : <em>void</em> |
| protected | <strong>execute(</strong><em>\Symfony\Component\Console\Input\InputInterface</em> <strong>$input</strong>, <em>\Symfony\Component\Console\Output\OutputInterface</em> <strong>$output</strong>)</strong> : <em>int/null/void</em> |

*This class extends \Symfony\Component\Console\Command\Command*

