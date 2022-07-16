<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Assign\SplitListAssignToSeparateLineRector;
use Rector\Config\RectorConfig;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->sets([
        SetList::CODE_QUALITY,
        SetList::CODING_STYLE,
        SetList::DEAD_CODE,
        SetList::EARLY_RETURN,
        SetList::PHP_81,
        SetList::NAMING,
        SetList::PRIVATIZATION,
        SetList::TYPE_DECLARATION,
        SetList::TYPE_DECLARATION_STRICT,
    ]);

    $rectorConfig->skip([
        RenameParamToMatchTypeRector::class,
        SplitListAssignToSeparateLineRector::class,
    ]);

    $rectorConfig->phpVersion(PhpVersion::PHP_81);
    $rectorConfig->importNames();
    $rectorConfig->importShortClasses();
    $rectorConfig->disableParallel();

    $rectorConfig->paths([
        __DIR__.'/app',
        __DIR__.'/public/index.php',
        __DIR__.'/rector.php',
    ]);
};
