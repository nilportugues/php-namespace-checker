<?php

namespace NilPortugues\NamespaceChecker\Checker\Repository;

use InvalidArgumentException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use NilPortugues\NamespaceChecker\Checker\Repository\Interfaces\FileSystem as FileSystemInterface;

class FileSystem implements FileSystemInterface
{
    /**
     * {@inheritdoc}
     */
    public function getFilesFromPath($path)
    {
        if (false === is_dir($path) && false === is_file($path)) {
            throw new InvalidArgumentException('Provided input is not a file nor a valid directory');
        }

        $files = [];
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));

        /** @var \SplFileInfo $filename */
        foreach ($iterator as $filename) {
            if ($filename->isDir()) {
                continue;
            }

            if ('php' === \strtolower($filename->getExtension())) {
                $files[] = $filename->getRealPath();
            }
        }

        return $files;
    }
}
