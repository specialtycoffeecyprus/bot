<?php

declare(strict_types=1);

return [
    'preset' => 'laravel',
    'exclude' => [
        'lang/',
    ],
    'remove' => [
        NunoMaduro\PhpInsights\Domain\Insights\ForbiddenDefineFunctions::class,
        NunoMaduro\PhpInsights\Domain\Insights\ForbiddenTraits::class,
        NunoMaduro\PhpInsights\Domain\Sniffs\ForbiddenSetterSniff::class,
        PHP_CodeSniffer\Standards\Generic\Sniffs\Commenting\TodoSniff::class,
        PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineLengthSniff::class,
        PHP_CodeSniffer\Standards\Generic\Sniffs\Formatting\SpaceAfterNotSniff::class,
        PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer::class,
        PhpCsFixer\Fixer\Import\OrderedImportsFixer::class,
        PhpCsFixer\Fixer\StringNotation\ExplicitStringVariableFixer::class,
        PhpCsFixer\Fixer\Whitespace\NoExtraBlankLinesFixer::class,
        SlevomatCodingStandard\Sniffs\Classes\ForbiddenPublicPropertySniff::class,
        SlevomatCodingStandard\Sniffs\Commenting\DocCommentSpacingSniff::class,
        SlevomatCodingStandard\Sniffs\Commenting\UselessInheritDocCommentSniff::class,
        SlevomatCodingStandard\Sniffs\ControlStructures\DisallowShortTernaryOperatorSniff::class,
        SlevomatCodingStandard\Sniffs\Namespaces\UseSpacingSniff::class,
        SlevomatCodingStandard\Sniffs\TypeHints\ParameterTypeHintSniff::class,
        SlevomatCodingStandard\Sniffs\TypeHints\PropertyTypeHintSniff::class,
        SlevomatCodingStandard\Sniffs\TypeHints\ReturnTypeHintSniff::class,
    ],
];
