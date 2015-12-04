<?php

namespace NilPortugues\NamespaceChecker\Checker\Composer;

/**
 * Class Reader.
 */
class Reader
{
    const PSR0 = 'psr-0';
    const PSR4 = 'psr-4';
    const AUTOLOAD = 'autoload';
    const AUTOLOAD_DEV = 'autoload-dev';

    /**
     * @param string $composerFile
     *
     * @return array
     */
    public static function getAutoloadPaths($composerFile)
    {
        $composerFile = self::jsonDecode($composerFile);

        $autoload = [
            self::PSR0 => [],
            self::PSR4 => [],
        ];

        $autoloadProd = self::getAutoloadValues($composerFile, self::AUTOLOAD);
        $autoloadDev = self::getAutoloadValues($composerFile, self::AUTOLOAD_DEV);

        $autoload[self::PSR0] = array_merge(
            (!empty($autoloadProd[self::PSR0])) ? $autoloadProd[self::PSR0] : [],
            (!empty($autoloadDev[self::PSR0])) ? $autoloadDev[self::PSR0] : []
        );

        $autoload[self::PSR4] = array_merge(
            (!empty($autoloadProd[self::PSR4])) ? $autoloadProd[self::PSR4] : [],
            (!empty($autoloadDev[self::PSR4])) ? $autoloadDev[self::PSR4] : []
        );

        return $autoload;
    }

    /**
     * @param array  $composer
     * @param string $key
     *
     * @return array
     */
    private static function getAutoloadValues(array $composer, $key)
    {
        return (!empty($composer[$key])) ? $composer[$key] : [];
    }

    /**
     * @param string $composerFile
     *
     * @return string
     */
    private static function jsonDecode($composerFile)
    {
        $composerFile = str_replace('\\', '\\\\', $composerFile);
        $composer = json_decode($composerFile, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \RuntimeException(json_last_error_msg());
        }

        return $composer;
    }
}
