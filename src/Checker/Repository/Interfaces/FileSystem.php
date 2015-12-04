<?php

namespace NilPortugues\NamespaceChecker\Checker\Repository\Interfaces;

interface FileSystem
{
    /**
     * @param string $path
     *
     * @return string[]
     */
    public function getFilesFromPath($path);
}
