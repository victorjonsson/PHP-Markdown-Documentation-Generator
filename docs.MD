## Table of contents

- [PHPDocsMD\ClassEntity](#class-phpdocsmdclassentity)
- [PHPDocsMD\CodeEntity](#class-phpdocsmdcodeentity)
- [PHPDocsMD\FunctionEntity](#class-phpdocsmdfunctionentity)
- [PHPDocsMD\MDTableGenerator](#class-phpdocsmdmdtablegenerator)
- [PHPDocsMD\ParamEntity](#class-phpdocsmdparamentity)
- [PHPDocsMD\Reflector](#class-phpdocsmdreflector)

## Class: PHPDocsMD\ClassEntity
| Visibility | Function |
|:-----------|:---------|
| public | <strong>generateAnchor()</strong> : <em>string</em> |
| public | <strong>generateTitle()</strong> : <em>string</em> |
| public | <strong>getFunctions()</strong> : <em>\PHPDocsMD\FunctionEntity[]</em> |
| public | <strong>hasIgnoreTag(<em>mixed</em> <strong>$toggle=null)</strong> : <em>bool</em> |
| public | <strong>isAbstract(<em>mixed</em> <strong>$toggle=null)</strong> : <em>bool</em> |
| public | <strong>isInterface(<em>mixed</em> <strong>$toggle=null)</strong> : <em>bool</em> |
| public | <strong>setFunctions(<em>array</em> <strong>$functions)</strong> : <em>void</em> |

## Class: PHPDocsMD\CodeEntity
| Visibility | Function |
|:-----------|:---------|
| public | <strong>getDeprecationMessage()</strong> : <em>string</em> |
| public | <strong>getDescription()</strong> : <em>string</em> |
| public | <strong>getName()</strong> : <em>string</em> |
| public | <strong>isDeprecated(<em>mixed</em> <strong>$toggle=null)</strong> : <em>void|bool</em> |
| public | <strong>setDeprecationMessage(<em>mixed</em> <strong>$deprecationMessage)</strong> : <em>void</em> |
| public | <strong>setDescription(<em>mixed</em> <strong>$description)</strong> : <em>void</em> |
| public | <strong>setName(<em>mixed</em> <strong>$name)</strong> : <em>void</em> |

## Class: PHPDocsMD\FunctionEntity
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

## Class: PHPDocsMD\MDTableGenerator
| Visibility | Function |
|:-----------|:---------|
| public | <strong>addFunc(<em>\PHPDocsMD\FunctionEntity</em> <strong>$func)</strong> : <em>void</em> |
| public | <strong>getTable()</strong> : <em>string</em> |
| public | <strong>openTable()</strong> : <em>void</em> |

## Class: PHPDocsMD\ParamEntity
| Visibility | Function |
|:-----------|:---------|
| public | <strong>getDefault()</strong> : <em>boolean</em> |
| public | <strong>getType()</strong> : <em>string</em> |
| public | <strong>setDefault(<em>mixed</em> <strong>$default)</strong> : <em>void</em> |
| public | <strong>setType(<em>mixed</em> <strong>$type)</strong> : <em>void</em> |

## Class: PHPDocsMD\Reflector
| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(<em>mixed</em> <strong>$className)</strong> : <em>void</em> |
| public | <strong>getClassEntity()</strong> : <em>\PHPDocsMD\ClassEntity</em> |
| public | <strong>getParamType(<em>\ReflectionParameter</em> <strong>$refParam)</strong> : <em>mixed</em> |

