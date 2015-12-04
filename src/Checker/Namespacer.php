<?php

namespace NilPortugues\NamespaceChecker\Checker;

use NilPortugues\NamespaceChecker\Checker\Composer\Reader;
use NilPortugues\NamespaceChecker\Checker\Repository\FileSystem;
use Zend\Code\Generator\FileGenerator;

/**
 * Class Namespacer
 * @package NilPortugues\NamespaceChecker
 */
class Namespacer
{
    /**
     * @var FileSystem
     */
    private $fileReader;
    /**
     * @var Reader
     */
    private $composerReader;

    /**
     * Namespacer constructor.
     */
    public function __construct()
    {
        $this->fileReader = new FileSystem();
        $this->composerReader = new Reader();
    }

    public function dryRun($path)
    {
        if (false === file_exists($path)) {
            throw new \InvalidArgumentException(sprintf("Provided composer.json file  at %s does not exist.", $path));
        }

        $autoloaders = $this->composerReader->getAutoloadPaths(file_get_contents($path));

        foreach($autoloaders as $psr => $filesUnderPsr) {
            foreach($filesUnderPsr as $namespace => $path) {
                $files = $this->fileReader->getFilesFromPath($path);

                if ($psr === Reader::PSR0) {
                    self::expectedPathForPsr0($files, $namespace);
                }

                if ($psr === Reader::PSR4) {
                    self::expectedPathForPsr4($files, $namespace);
                }

            }
        }


    }

    private function expectedPathForPsr0(array $filePaths, $namespace) {

        print_r(func_get_args());
    }

    private function expectedPathForPsr4(array $filePaths, $namespace)
    {
        foreach($filePaths as $file) {
            $generator = FileGenerator::fromReflectedFileName($file);
                $phpClassName = $generator->getClass()->getName();
                $fileClassName = pathinfo($file, PATHINFO_FILENAME);

                $phpClassNamespace = $generator->getClass()->getNamespaceName();
        }

        print_r(func_get_args()); die();
    }
}