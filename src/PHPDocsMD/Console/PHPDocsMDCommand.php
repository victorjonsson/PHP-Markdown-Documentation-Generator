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
 * @ignore
 */
class PHPDocsMDCommand extends \Symfony\Component\Console\Command\Command {

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
        foreach($classCollection as $ns => $classes) {
            foreach($classes as $className) {
                $reflector = new Reflector($className);
                $class = $reflector->getClassEntity();

                if( $class->hasIgnoreTag() )
                    continue;

                // Add to tbl of contents
                $tableOfContent[] = sprintf('- [%s](#%s)', $class->getName(), $class->generateAnchor());

                // generate function table
                $tableGenerator->openTable();
                foreach($class->getFunctions() as $func) {
                    $tableGenerator->addFunc($func);
                }

                $body[] = '## '.$class->generateTitle().PHP_EOL.$tableGenerator->getTable().PHP_EOL;
            }
        }

        if(empty($tableOfContent)) {
            throw new \InvalidArgumentException('No classes found');
        } elseif( count($tableOfContent) > 1 ) {
            $output->writeln('## Table of contents'.PHP_EOL);
            $output->writeln(implode(PHP_EOL, $tableOfContent));
        }

        $output->writeln(PHP_EOL . implode(PHP_EOL, $body));
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
                if( class_exists($className, true) ) {
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