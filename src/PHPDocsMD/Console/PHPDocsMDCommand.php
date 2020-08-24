<?php
namespace PHPDocsMD\Console;

use PHPDocsMD\MDTableGenerator;
use PHPDocsMD\Reflector;
use PHPDocsMD\TableGenerator;
use PHPDocsMD\Utils;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * Console command used to extract markdown-formatted documentation from classes
 * @package PHPDocsMD\Console
 */
class PHPDocsMDCommand extends \Symfony\Component\Console\Command\Command {

    const ARG_CLASS = 'class';
    const OPT_BOOTSTRAP = 'bootstrap';
    const OPT_IGNORE = 'ignore';
    const OPT_VISIBILITY = 'visibility';
    const OPT_METHOD_REGEX = 'methodRegex';
    const OPT_TABLE_GENERATOR = 'tableGenerator';
    const OPT_SEE = 'see';
    const OPT_NO_INTERNAL = 'no-internal';

    /**
     * @var array
     */
    private $memory = [];

    /**
     * @var array
     */
    private $visibilityFilter = [];

    /**
     * @var string
     */
    private $methodRegex = '';

    /**
     * @param $name
     * @return \PHPDocsMD\ClassEntity
     */
    private function getClassEntity($name) {
        if( !isset($this->memory[$name]) ) {
            $reflector = new Reflector($name);
            if ( ! empty($this->visibilityFilter)) {
                $reflector->setVisibilityFilter($this->visibilityFilter);
            }
            if ( ! empty($this->methodRegex)) {
                $reflector->setMethodRegex($this->methodRegex);
            }
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
                self::ARG_CLASS,
                InputArgument::REQUIRED,
                'Class or source directory'
            )
            ->addOption(
                self::OPT_BOOTSTRAP,
                'b',
                InputOption::VALUE_REQUIRED,
                'File to be included before generating documentation'
            )
            ->addOption(
                self::OPT_IGNORE,
                'i',
                InputOption::VALUE_REQUIRED,
                'Directories to ignore',
                ''
            )
            ->addOption(
                self::OPT_VISIBILITY,
                null,
                InputOption::VALUE_OPTIONAL,
                'The visibility of the methods to import, a comma-separated list.',
                ''
            )
            ->addOption(
                self::OPT_METHOD_REGEX,
                null,
                InputOption::VALUE_OPTIONAL,
                'The full regular expression methods should match to be included in the output.',
                ''
            )
            ->addOption(
                self::OPT_TABLE_GENERATOR,
                null,
                InputOption::VALUE_OPTIONAL,
                'The slug of a supported table generator class or a fully qualified TableGenerator interface implementation class name.',
                'default'
          )
          ->addOption(
                self::OPT_SEE,
                null,
                InputOption::VALUE_NONE,
                'Include @see in generated markdown'
             )
             ->addOption(
                self::OPT_NO_INTERNAL,
                null,
                InputOption::VALUE_NONE,
                'Ignore entities marked @internal'
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null
     * @throws \InvalidArgumentException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $classes = $input->getArgument(self::ARG_CLASS);
        $bootstrap = $input->getOption(self::OPT_BOOTSTRAP);
        $ignore = explode(',', $input->getOption(self::OPT_IGNORE));
        $this->visibilityFilter = empty($input->getOption(self::OPT_VISIBILITY))
            ? ['public', 'protected', 'abstract', 'final']
            : array_map('trim', preg_split('/\\s*,\\s*/', $input->getOption(self::OPT_VISIBILITY)));
        $this->methodRegex = $input->getOption(self::OPT_METHOD_REGEX) ?: false;
        $includeSee = $input->getOption(self::OPT_SEE);
        $noInternal = $input->getOption(self::OPT_NO_INTERNAL);
        $requestingOneClass = false;

        if( $bootstrap ) {
            require_once strpos($bootstrap,'/') === 0 ? $bootstrap : getcwd().'/'.$bootstrap;
        }

        $classCollection = [];
        if( strpos($classes, ',') !== false ) {
            foreach(explode(',', $classes) as $class) {
                if( class_exists($class) || interface_exists($class) || trait_exists($class) )
                    $classCollection[0][] = $class;
            }
        }
        elseif( class_exists($classes) || interface_exists($classes) || trait_exists($classes) ) {
            $classCollection[] = array($classes);
            $requestingOneClass = true;
        } elseif( is_dir($classes) ) {
            $classCollection = $this->findClassesInDir($classes, [], $ignore);
        } else {
            throw new \InvalidArgumentException('Given input is neither a class nor a source directory');
        }

        $tableGeneratorSlug = $input->getOption(self::OPT_TABLE_GENERATOR);
        $tableGenerator = $this->buildTableGenerator($tableGeneratorSlug);

        $tableOfContent = [];
        $body = [];
        $classLinks = [];

        foreach($classCollection as $ns => $classes) {
            foreach($classes as $className) {
                $class = $this->getClassEntity($className);

                if ($class->hasIgnoreTag()
                        || ($class->hasInternalTag() && $noInternal)) {
                    continue;
                }

                // Add to tbl of contents
                $tableOfContent[] = sprintf('- [%s](#%s)', $class->generateTitle('%name% %extra%'), $class->generateAnchor());

                $classLinks[$class->getName()] = '#'.$class->generateAnchor();

                // generate function table
                $tableGenerator->openTable();
                $tableGenerator->doDeclareAbstraction(!$class->isInterface());
                foreach($class->getFunctions() as $func) {
                    if ($func->isInternal() && $noInternal) {
                        continue;
                    }
                    if ($func->isReturningNativeClass()) {
                        $classLinks[$func->getReturnType()] = 'http://php.net/manual/en/class.'.
                            strtolower(str_replace(array('[]', '\\'), '', $func->getReturnType())).
                            '.php';
                    }
                    foreach($func->getParams() as $param) {
                        if ($param->getNativeClassType()) {
                            $classLinks[$param->getNativeClassType()] = 'http://php.net/manual/en/class.'.
                                strtolower(str_replace(array('[]', '\\'), '', $param->getNativeClassType())).
                                '.php';
                        }
                    }
                    $tableGenerator->addFunc($func, $includeSee);
                }

                $docs = ($requestingOneClass ? '':'<hr /><a id="' . trim($classLinks[$class->getName()], '#') . '"></a>'.PHP_EOL);

                if( $class->isDeprecated() ) {
                    $docs .= '### <strike>'.$class->generateTitle().'</strike>'.PHP_EOL.PHP_EOL.
                            '> **DEPRECATED** '.$class->getDeprecationMessage().PHP_EOL.PHP_EOL;
                }
                else {
                    $docs .= '### '.$class->generateTitle().PHP_EOL.PHP_EOL;
                    if( $class->getDescription() )
                        $docs .= '> '.$class->getDescription().PHP_EOL.PHP_EOL;
                }

                if ($includeSee && $seeArray = $class->getSee()) {
                    foreach ($seeArray as $see) {
                        $docs .= 'See ' . $see . '<br />' . PHP_EOL;
                    }
                    $docs .= PHP_EOL;
                }

                if( $example = $class->getExample() ) {
                    $docs .= '###### Example' . PHP_EOL . MDTableGenerator::formatExampleComment($example) .PHP_EOL.PHP_EOL;
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
                    $interfaceNames = [];
                    foreach($interfaces as $interface) {
                        $anchor = $this->getAnchorFromClassCollection($classCollection, $interface);
                        $interfaceNames[] = $anchor ? sprintf('[%s](#%s)', $interface, $anchor) : $interface;
                    }
                    $docs .= PHP_EOL.'*This class implements '.implode(', ', $interfaceNames).'*'.PHP_EOL;
                }

                $body[] = $docs;
            }
        }

        if( empty($tableOfContent) ) {
            throw new \InvalidArgumentException('No classes found');
        } elseif( !$requestingOneClass ) {
            $output->writeln('## Table of contents'.PHP_EOL);
            $output->writeln(implode(PHP_EOL, $tableOfContent));
        }

        // Convert references to classes into links
        asort($classLinks);
        $classLinks = array_reverse($classLinks, true);
        $docString = implode(PHP_EOL, $body);
        foreach($classLinks as $className => $url) {
            $link = sprintf('[%s](%s)', $className, $url);
            $find = array('<em>'.$className, '/'.$className);
            $replace = array('<em>'.$link, '/'.$link);
            $docString = str_replace($find, $replace, $docString);
        }

        $output->writeln(PHP_EOL.$docString);
        
        return 0;
    }

    /**
     * @param $coll
     * @param $find
     * @return bool|string
     */
    private function getAnchorFromClassCollection($coll, $find)
    {
        foreach($coll as $ns => $classes) {
            foreach($classes as $className) {
                if( $className == $find ) {
                    return $this->getClassEntity($className)->generateAnchor();
                }
            }
        }
        return false;
    }

    /**
     * @param $file
     * @return array
     */
    private function findClassInFile($file)
    {
        $ns = '';
        $class = false;
        foreach(explode(PHP_EOL, file_get_contents($file)) as $line) {
            if ( strpos($line, '*') === false ) {
                if( strpos($line, 'namespace') !== false ) {
                    $ns = trim(current(array_slice(explode('namespace', $line), 1)), '; ');
                    $ns = Utils::sanitizeClassName($ns);
                } elseif( strpos($line, 'class') !== false ) {
                    $class = $this->extractClassNameFromLine('class', $line);
                    break;
                } elseif( strpos($line, 'interface') !== false ) {
                    $class = $this->extractClassNameFromLine('interface', $line);
                    break;
                }
            }
        }
        return $class ? array($ns, $ns .'\\'. $class) : array(false, false);
    }

    /**
     * @param string $type
     * @param string $line
     * @return string
     */
    function extractClassNameFromLine($type, $line)
    {
        $class = trim(current(array_slice(explode($type, $line), 1)), '; ');
        return trim(current(explode(' ', $class)));
    }

    /**
     * @param $dir
     * @param array $collection
     * @param array $ignores
     * @return array
     */
    private function findClassesInDir($dir, $collection=[], $ignores=[])
    {
        foreach(new \FilesystemIterator($dir) as $f) {
            /** @var \SplFileInfo $f */
            if( $f->isFile() && !$f->isLink() ) {
                list($ns, $className) = $this->findClassInFile($f->getRealPath());
                if( $className && (class_exists($className, true) || interface_exists($className) || trait_exists($className)) ) {
                    $collection[$ns][] = $className;
                }
            } elseif( $f->isDir() && !$f->isLink() && !$this->shouldIgnoreDirectory($f->getFilename(), $ignores) ) {
                $collection = $this->findClassesInDir($f->getRealPath(), $collection);
            }
        }
        ksort($collection);
        return $collection;
    }

    /**
     * @param $dirName
     * @param $ignores
     * @return bool
     */
    private function shouldIgnoreDirectory($dirName, $ignores) {
        foreach($ignores as $dir) {
            $dir = trim($dir);
            if( !empty($dir) && substr($dirName, -1 * strlen($dir)) == $dir ) {
                return true;
            }
        }
        return false;
    }

    protected function buildTableGenerator($tableGeneratorSlug = 'default')
    {
        if (class_exists($tableGeneratorSlug)) {
            if (!in_array(TableGenerator::class, class_implements($tableGeneratorSlug), true)) {
                throw new \InvalidArgumentException('The table generator class should implement the ' .
                                                    TableGenerator::class . ' interface.');
            }

            return new $tableGeneratorSlug();
        }

        $map = [
            'default' => MDTableGenerator::class,
        ];

        $class = isset($map[$tableGeneratorSlug]) ? $map[$tableGeneratorSlug] : $map['default'];

        return new $class;
    }

}
