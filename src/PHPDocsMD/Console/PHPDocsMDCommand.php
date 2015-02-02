<?php
namespace PHPDocsMD\Console;

use PHPDocsMD\MDTableGenerator;
use PHPDocsMD\Reflector;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * Command line interface for extracting markdown-formatted class documentation
 * @package PHPDocsMD\Console
 */
class PHPDocsMDCommand extends \Symfony\Component\Console\Command\Command {

    private $memory = array();

    /**
     * @param $name
     * @return \PHPDocsMD\ClassEntity
     */
    private function getClassEntity($name) {
        if( !isset($this->memory[$name]) ) {
            $reflector = new Reflector($name);
            $this->memory[$name] = $reflector->getClassEntity();
        }
        return $this->memory[$name];
    }

    protected function configure()
    {
        $this
            ->setName('generate')
            ->setDescription('Get docs for given class/source directory)')
            ->addArgument(
                'class',
                InputArgument::REQUIRED,
                'Class or source directory'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $input = $input->getArgument('class');
        $classCollection = array();

        if( class_exists($input) ) {
            $classCollection[] = array($input);
        } elseif( is_dir($input) ) {
            $classCollection = $this->findClassesInDir($input);
        } else {
            throw new \InvalidArgumentException('Given input is neither a class nor a source directory');
        }

        $tableGenerator = new MDTableGenerator();
        $tableOfContent = array();
        $body = array();
        $classLinks = array();

        foreach($classCollection as $ns => $classes) {
            foreach($classes as $className) {
                $class = $this->getClassEntity($className);

                if( $class->hasIgnoreTag() )
                    continue;

                // Add to tbl of contents
                $tableOfContent[] = sprintf('- [%s](#%s)', $class->getName(), $class->generateAnchor());
                $classLinks[$class->generateAnchor()] = '\\'.$class->getName();

                // generate function table
                $tableGenerator->openTable();
                foreach($class->getFunctions() as $func) {
                    $tableGenerator->addFunc($func);
                }

                $docs = '<hr /> '.PHP_EOL.'### '.$class->generateTitle().PHP_EOL;

                if( $class->isDeprecated() ) {
                    $docs .= PHP_EOL.'> **DEPRECATED** '.$class->getDeprecationMessage().PHP_EOL.PHP_EOL;
                }
                elseif( $class->getDescription() ) {
                    $docs .= PHP_EOL.'> '.$class->getDescription().PHP_EOL.PHP_EOL;
                }

                $docs .= $tableGenerator->getTable().PHP_EOL;

                if( $class->getExtends() ) {
                    $link = $class->getExtends();
                    if( $anchor = $this->getAnchorFromClassCollection($classCollection, $class->getExtends()) ) {
                        $link = sprintf('[%s](#%s)', $link, $anchor);
                    }

                    $docs .= PHP_EOL.'*This class extends '.$link.'*'.PHP_EOL;
                }

                if( $interfaces = $class->getInterfaces() ) {
                    $interfaceNames = array();
                    foreach($interfaces as $interface) {
                        $anchor = $this->getAnchorFromClassCollection($classCollection, $interface);
                        $interfaceNames[] = $anchor ? sprintf('[%s](#%s)', $interface, $anchor) : $interface;
                    }
                    $docs .= PHP_EOL.'*This class implements '.implode(', ', $interfaceNames).'*'.PHP_EOL;
                }

                $body[] = $docs;
            }
        }

        if(empty($tableOfContent)) {
            throw new \InvalidArgumentException('No classes found');
        } elseif( count($tableOfContent) > 1 ) {
            $output->writeln('## Table of contents'.PHP_EOL);
            $output->writeln(implode(PHP_EOL, $tableOfContent));
        }

        $docString = implode(PHP_EOL, $body);
        foreach($classLinks as $anchor => $className) {
            $replace = '<em>'.sprintf('[%s](#%s)', $className, $anchor);
            $find = '<em>'.$className;
            $docString = str_replace($find, $replace, $docString);
        }

        $output->writeln(PHP_EOL . $docString);
    }

    /**
     * @param array $coll
     * @param  $className
     */
    private function getAnchorFromClassCollection($coll, $find) {
        foreach($coll as $ns => $classes) {
            foreach($classes as $className) {
                if( $className == $find ) {
                    return $this->getClassEntity($className)->generateAnchor();
                }
            }
        }
        return false;
    }

    private function findClassInFile($file) {
        foreach(explode(PHP_EOL, file_get_contents($file)) as $line) {
            if( strpos($line, 'namespace') !== false ) {
                $ns = trim(current(array_slice(explode('namespace', $line), 1)), '; ');
                return array($ns, $ns.'\\'.pathinfo($file, PATHINFO_FILENAME));
            }
        }
        return false;
    }

    private function findClassesInDir($dir, $collection=array())
    {
        foreach(new \FilesystemIterator($dir) as $f) {
            /** @var \SplFileInfo $f */
            if( $f->isFile() && !$f->isLink() ) {
                list($ns, $className) = $this->findClassInFile($f->getRealPath());
                if( class_exists($className, true) || interface_exists($className) ) {
                    $collection[$ns][] = $className;
                }
            } elseif( $f->isDir() && !$f->isLink() ) {
                $collection = $this->findClassesInDir($f->getRealPath(), $collection);
            }
        }
        ksort($collection);
        return $collection;
    }

}