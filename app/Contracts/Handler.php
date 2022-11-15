<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Answers\Answer;

interface Handler
{
    /** @return Answer|array<Answer> */
    public function getAnswer(): Answer|array;
}
