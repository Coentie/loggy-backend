<?php

namespace App\Jobs\Issue\Stacktrace;

use App\Models\Issue\Stacktrace;
use App\ValueObjects\Issue\StacktraceValueObject;

class StoreStacktraceJob
{
    /**
     * Stores a stacktrace
     *
     * @param \App\ValueObjects\Issue\StacktraceValueObject $obj
     */
    public function __construct(public StacktraceValueObject $obj) {}

    /**
     * Handles the job.
     *
     * @return \App\Models\Issue\Stacktrace
     */
    public function handle(): Stacktrace {
        $stacktrace = new Stacktrace();
        $stacktrace->occurrence()->associate($this->obj->occurrence);
        $stacktrace->trace = $this->obj->stacktrace;
        $stacktrace->save();

        return $stacktrace;
    }
}
