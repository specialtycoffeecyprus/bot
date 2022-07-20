<?php

declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;
use Throwable;

final class NotFoundException extends RuntimeException
{
    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        $message = $message ?: 'No such coffee shop was found ☹️';

        parent::__construct($message, $code, $previous);
    }
}
