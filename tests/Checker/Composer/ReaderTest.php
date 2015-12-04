<?php

namespace NilPortugues\Tests\NamespaceChecker\Checker\Composer;

use NilPortugues\NamespaceChecker\Checker\Composer\Reader;

/**
 * Class ReaderTest.
 */
class ReaderTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function getComposerFile()
    {
        return <<<JSON
{
    "autoload": {
        "psr-0": {
            "": "src/",
            "NilPortugues\\AnotherPackage": "src/NilPortugues/AnotherPackage"
        },
        "psr-4": {
            "NilPortugues\\Serializer\\Drivers\\Eloquent\\": "src/"
        }
    },
    "autoload-dev": {
        "psr-0": {
            "": "tests/",
            "NilPortugues\\Tests\\AnotherPackage": "tests/NilPortugues/AnotherPackage"
        },
        "psr-4": {
            "NilPortugues\\Tests\\Serializer\\Drivers\\Eloquent\\": "tests/"
        }
    }
}
JSON;
    }

    /**
     *
     */
    public function testItReadsPsr0()
    {
        $composer = $this->getComposerFile();
        $namespaces = Reader::readAutoloader($composer);
        $this->assertNotEmpty($namespaces[Reader::PSR0]);
    }

    /**
     *
     */
    public function testItReadsPsr4()
    {
        $composer = $this->getComposerFile();
        $namespaces = Reader::readAutoloader($composer);
        $this->assertNotEmpty($namespaces[Reader::PSR4]);
    }
}
