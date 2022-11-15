<?php

declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;
use Throwable;

final class LocationPublicDenied extends RuntimeException
{
    public const TEXT = 'Bad Request: location can be requested in private chats only';


    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        $message = $message ?: 'Nearest cafes available in private chats only';

        parent::__construct($message, $code, $previous);
    }
}
