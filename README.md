### *wip...*

# PHP-Markdown-Documentation-Generator

The documentation is just as important as the code it's refering to. With this command line tool 
you will be able to write your documentation once, and only once! 

Write you code documentation following the standard set by [phpdoc](http://www.phpdoc.org/) and generate markdown-formatted documenation by calling `phpdocs-md` in your console and get a full documenation of your code base.

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

By then calling `$ phpdocs-md src >> docs.md` in your console (the argument being the path to your class directory) you will get the following output written to docs.md

```

## Class: Acme\MyObject

This is a description of this class

| Visibility | Function |
|:-----------|:---------|
| public     | function someFunc(<em>string</em> $str, <em>array</em> $array=array()) : <em>Acme\OtherObject</em> <br /> This is a function description |

## Class: Acme\OtherObject

Perhaps a description of this class

| Visibility | Function |
|:-----------|:---------|
| public     | function someFunc(<em>string</em> $str, <em>array</em> $array=array()) : <em>bool</em> |

```


### Requirements

- PHP version >= 5.3.0
- Reflection activated in php.ini
- Each class in its own file with the file name being the same as the class name.

### Installation
