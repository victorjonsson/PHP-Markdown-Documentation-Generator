# PHP-Markdown-Documentation-Generator

The documentation is just as important as the code it's refering to. With this command line tool 
you will be able to write your documentation once, and only once! 

Write your code documentation following the standard set by [phpdoc](http://www.phpdoc.org/) and generate a markdown-formatted
documentation by calling `phpdocs-md` in your console.

![Travis](https://travis-ci.org/victorjonsson/PHP-Markdown-Documentation-Generator.svg)

### Example

Let's say you have your PHP classes in a directory named "src". Each class has its own file named the same way as the class.

```
- src/
  - MyObject.php
  - OtherObject.php
```

You write your code documentation following the standard set by [phpdoc](http://www.phpdoc.org/). 

```php
namespace Acme;

/**
 * This is a description of this class
 */
class MyObject {
   
   /**
    * This is a function description
    * @param string $str
    * @param array $arr
    * @return Acme\OtherObject
    */
   function someFunc($str, $arr=array()) {
   
   }
}
```

By then calling `$ phpdocs-md generate src > docs.md` in your console (the second argument being the path
to your class directory) your class documentation will be written to docs.md.

[Here you can see a rendered example](https://github.com/victorjonsson/PHP-Markdown-Documentation-Generator/blob/master/docs.md)

Only public and protected functions will be a part of the documentation but you can also add `@ignore` to any function or class to exclude it from the docs. The program will try to guess the return type of functions that don't declare the return type. The program uses reflection to get as much information as possible out of the code so that functions that's missing doc comments will also be  included in the generated documentation.

### Requirements

- PHP version >= 5.3.2
- Reflection activated in php.ini
- Each class in its own file with the file name being the same as the class name.

### Installation / Usage

This command line tool can be installed using [composer](https://getcomposer.org/). Add `"victorjonsson/markdowndocs": "dev-master"` to composer.json and run install/update. Now you can choose to use `vendor/victorjonsson/markdowndocs/bin/phpdocs-md` directly as an executable or copy it to your project root by calling `$ cp vendor/victorjonsson/markdowndocs/bin/phpdocs-md phpdocs-md`

##### Generating docs

To generate the documentation you use the command `generate`. The command line tool also needs to know whether you want to generate docs for a certain class or if it should search through a directory after class files.

```
# Generate docs for a certain class
$ ./phpdocs-md generate Acme\\NS\\MyClass 

# Generate docs for several classes (comma separated)
$ ./phpdocs-md generate Acme\\NS\\MyClass,Acme\\OtherNS\\OtherClass 

# Generate docs for all classes in a source directory
$ ./phpdocs-md generate includes/src

# Generate docs for all classes in a source directory and send output to the file docs.md
$ ./phpdocs-md generate includes/src > docs.md
```

*Note that the classes has to be possible to load using the autoloader provided by composer.*

##### Bootstrapping

Maybe your not using the autloader provided by composer or maybe there is something else that needs to be done before your classes can be instantiated. In that case you can tell the command line tool to load a php-file before generating the docs

`$ ./phpdocs-md generate --bootstrap=includes/init.php includes/src > docs.md`

######  Excluding directories

You can tell the command line tool to ignore certain directories in your class path by using the ignore-option.

`$ ./phpdocs-md generate --ignore=test,mustasche includes/src > docs.md`
