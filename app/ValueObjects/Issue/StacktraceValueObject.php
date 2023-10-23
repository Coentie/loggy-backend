<?php

namespace App\ValueObjects\Issue;

use App\Models\Issue\Occurrence;
use App\ValueObjects\IsValueObject;

class StacktraceValueObject implements IsValueObject
{
    /**
     * @var \App\Models\Issue\Occurrence
     */
    public Occurrence $occurrence;

    /**
     * @var string
     */
    public string $stacktrace;
}
