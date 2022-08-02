<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Assign\SplitListAssignToSeparateLineRector;
use Rector\CodingStyle\Rector\ClassConst\VarConstantCommentRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\CodingStyle\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector;
use Rector\Config\RectorConfig;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector;
use Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector;
use Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector;
use Rector\PHPUnit\Set\PHPUnitLevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\TypeDeclaration\Rector\ClassMethod\ArrayShapeFromConstantArrayReturnRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->sets([
        SetList::PHP_81,
        SetList::CODE_QUALITY,
        SetList::CODING_STYLE,
        SetList::DEAD_CODE,
        SetList::EARLY_RETURN,
        SetList::NAMING,
        SetList::PRIVATIZATION,
        SetList::TYPE_DECLARATION,
        SetList::TYPE_DECLARATION_STRICT,
        PHPUnitLevelSetList::UP_TO_PHPUNIT_100,
    ]);

    $rectorConfig->skip([
        ArrayShapeFromConstantArrayReturnRector::class,
        EncapsedStringsToSprintfRector::class,
        RenameParamToMatchTypeRector::class,
        RenamePropertyToMatchTypeRector::class,
        RenameVariableToMatchMethodCallReturnTypeRector::class,
        SplitListAssignToSeparateLineRector::class,
        VarConstantCommentRector::class,
        WrapEncapsedVariableInCurlyBracesRector::class,
    ]);

    $rectorConfig->phpVersion(PhpVersion::PHP_81);
    $rectorConfig->importNames();
    $rectorConfig->importShortClasses();
    $rectorConfig->disableParallel();

    $rectorConfig->paths([
        __DIR__.'/app',
        __DIR__.'/public/index.php',
        __DIR__.'/tests',
        __DIR__.'/rector.php',
    ]);
};
