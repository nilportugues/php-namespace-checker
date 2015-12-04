<?php
include 'vendor/autoload.php';

use NilPortugues\NamespaceChecker\Checker\Namespacer;

$namespacer = new Namespacer();
$namespacer->dryRun('./composer.json');
