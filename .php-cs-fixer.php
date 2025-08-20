<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database',
        __DIR__ . '/resources',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ])
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new Config)
    ->setFinder($finder)
    ->setRules([
        // Applies the PSR-2 coding standard which Laravel follows
        '@PSR2' => true,

        // Ensures that there is a single space around binary operators
        'binary_operator_spaces' => [
            'default' => 'single_space',
        ],

        // Enforces the use of short array syntax ([] instead of array())
        'array_syntax' => ['syntax' => 'short'],

        // Ensures that there is no single blank line at the end of the file
        'single_blank_line_at_eof' => true,

        // Removes `use` statements that are not used in the code
        'no_unused_imports' => true,

        // Ensures that there is a trailing comma in multi-line arrays or function arguments
        'trailing_comma_in_multiline' => true,

        // Ensures that there is no space around unary operators (++, --)
        'unary_operator_spaces' => true,

        // Ensures that there is no space around the object operator (->)
        'object_operator_without_whitespace' => true,

        // Ensures that there is no trailing comma in single-line arrays
        'no_trailing_comma_in_singleline_array' => true,

        // Ensures that there is a single blank line before a namespace declaration
        'single_blank_line_before_namespace' => true,

        // Ensures that there are spaces around the ternary operator
        'ternary_operator_spaces' => true,
    ])
    ->setRiskyAllowed(true)
    ->setUsingCache(true);
