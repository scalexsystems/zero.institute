<?php

$finder = PhpCsFixer\Finder::create()
    ->in(['app', 'routes', 'config', 'database', 'tests', 'resources/lang']);

return PhpCsFixer\Config::create()
    ->setRules(array(
        '@PSR2' => true,
        // 'strict_param' => true,
        'array_syntax' => array('syntax' => 'short'),
    ))
    ->setFinder($finder);
