## Table of contents

- [PHPDocsMD\ClassEntity](#class-phpdocsmdclassentity)
- [PHPDocsMD\CodeEntity](#class-phpdocsmdcodeentity)
- [PHPDocsMD\FunctionEntity](#class-phpdocsmdfunctionentity)
- [PHPDocsMD\MDTableGenerator](#class-phpdocsmdmdtablegenerator)
- [PHPDocsMD\ParamEntity](#class-phpdocsmdparamentity)
- [PHPDocsMD\Reflector](#class-phpdocsmdreflector)
- [PHPDocsMD\ReflectorInterface](#interface-phpdocsmdreflectorinterface)
- [PHPDocsMD\Console\CLI](#class-phpdocsmdconsolecli)
- [PHPDocsMD\Console\PHPDocsMDCommand](#class-phpdocsmdconsolephpdocsmdcommand)

<hr /> 
### Class: PHPDocsMD\ClassEntity

*This class extends [PHPDocsMD\CodeEntity](#class-phpdocsmdcodeentity)*

> Object describing a class or a interface

| Visibility | Function |
|:-----------|:---------|
| public | <strong>generateAnchor()</strong> : <em>string</em> |
| public | <strong>generateTitle()</strong> : <em>string</em> |
| public | <strong>getExtends()</strong> : <em>string</em> |
| public | <strong>getFunctions()</strong> : <em>\PHPDocsMD\FunctionEntity[]</em> |
| public | <strong>getInterfaces()</strong> : <em>array</em> |
| public | <strong>hasIgnoreTag(<em>mixed</em> <strong>$toggle=null)</strong> : <em>bool</em> |
| public | <strong>isAbstract(<em>mixed</em> <strong>$toggle=null)</strong> : <em>bool</em> |
| public | <strong>isInterface(<em>mixed</em> <strong>$toggle=null)</strong> : <em>bool</em> |
| public | <strong>setExtends(<em>mixed</em> <strong>$extends)</strong> : <em>void</em> |
| public | <strong>setFunctions(<em>array</em> <strong>$functions)</strong> : <em>void</em> |
| public | <strong>setInterfaces(<em>array</em> <strong>$implements)</strong> : <em>void</em> |

<hr /> 
### Class: PHPDocsMD\CodeEntity

> Object describing a piece of code

| Visibility | Function |
|:-----------|:---------|
| public | <strong>getDeprecationMessage()</strong> : <em>string</em> |
| public | <strong>getDescription()</strong> : <em>string</em> |
| public | <strong>getName()</strong> : <em>string</em> |
| public | <strong>isDeprecated(<em>mixed</em> <strong>$toggle=null)</strong> : <em>void|bool</em> |
| public | <strong>setDeprecationMessage(<em>mixed</em> <strong>$deprecationMessage)</strong> : <em>void</em> |
| public | <strong>setDescription(<em>mixed</em> <strong>$description)</strong> : <em>void</em> |
| public | <strong>setName(<em>mixed</em> <strong>$name)</strong> : <em>void</em> |

<hr /> 
### Class: PHPDocsMD\FunctionEntity

*This class extends [PHPDocsMD\CodeEntity](#class-phpdocsmdcodeentity)*

> Object describing a function

| Visibility | Function |
|:-----------|:---------|
| public | <strong>getParams()</strong> : <em>\PHPDocsMD\ParamEntity[]</em> |
| public | <strong>getReturnType()</strong> : <em>string</em> |
| public | <strong>getVisibility()</strong> : <em>string</em> |
| public | <strong>hasParams()</strong> : <em>bool</em> |
| public | <strong>isAbstract(<em>mixed</em> <strong>$toggle=null)</strong> : <em>bool</em> |
| public | <strong>setParams(<em>array</em> <strong>$params)</strong> : <em>void</em> |
| public | <strong>setReturnType(<em>mixed</em> <strong>$returnType)</strong> : <em>void</em> |
| public | <strong>setVisibility(<em>mixed</em> <strong>$visibility)</strong> : <em>void</em> |

<hr /> 
### Class: PHPDocsMD\MDTableGenerator

> Class that can create a markdown-formatted table describing class functions referred to via FunctionEntity objects

| Visibility | Function |
|:-----------|:---------|
| public | <strong>addFunc(<em>\PHPDocsMD\FunctionEntity</em> <strong>$func)</strong> : <em>void</em> |
| public | <strong>getTable()</strong> : <em>string</em> |
| public | <strong>openTable()</strong> : <em>void</em> |

<hr /> 
### Class: PHPDocsMD\ParamEntity

*This class extends [PHPDocsMD\CodeEntity](#class-phpdocsmdcodeentity)*

> Object describing a function parameter

| Visibility | Function |
|:-----------|:---------|
| public | <strong>getDefault()</strong> : <em>boolean</em> |
| public | <strong>getType()</strong> : <em>string</em> |
| public | <strong>setDefault(<em>mixed</em> <strong>$default)</strong> : <em>void</em> |
| public | <strong>setType(<em>mixed</em> <strong>$type)</strong> : <em>void</em> |

<hr /> 
### Class: PHPDocsMD\Reflector

*This class implements [PHPDocsMD\ReflectorInterface](#interface-phpdocsmdreflectorinterface)*

> Class that can compute ClassEntity objects out of real classes

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(<em>mixed</em> <strong>$className)</strong> : <em>void</em> |
| public | <strong>getClassEntity()</strong> : <em>\PHPDocsMD\ClassEntity</em> |
| public | <strong>getParamType(<em>\ReflectionParameter</em> <strong>$refParam)</strong> : <em>mixed</em> |

<hr /> 
### Interface: PHPDocsMD\ReflectorInterface

> Interface for classes that can compute ClassEntity objects

| Visibility | Function |
|:-----------|:---------|
| public | abstract getClassEntity()</strong> : <em>\PHPDocsMD\ClassEntity</em> |
| public | abstract getParamType(<em>\ReflectionParameter</em> <strong>$refParam)</strong> : <em>string</em><br />Get declared type of a parameter. Will return empty string if not |

<hr /> 
### Class: PHPDocsMD\Console\CLI

*This class extends Symfony\Component\Console\Application*

> Command line interface for extracting markdown-formatted class documentation

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct()</strong> : <em>void</em> |
| public | <strong>run(<em>\Symfony\Component\Console\Input\InputInterface</em> <strong>$input=null</strong><em>\Symfony\Component\Console\Output\OutputInterface</em> <strong>$output=null)</strong> : <em>int</em> |

<hr /> 
### Class: PHPDocsMD\Console\PHPDocsMDCommand

*This class extends Symfony\Component\Console\Command\Command*

> Command line interface for extracting markdown-formatted class documentation

| Visibility | Function |
|:-----------|:---------|
| protected | <strong>configure()</strong> : <em>void</em> |
| protected | <strong>execute(<em>\Symfony\Component\Console\Input\InputInterface</em> <strong>$input</strong><em>\Symfony\Component\Console\Output\OutputInterface</em> <strong>$output)</strong> : <em>void</em> |

