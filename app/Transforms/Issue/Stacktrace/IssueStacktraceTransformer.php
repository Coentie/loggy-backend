<?php

namespace App\Transforms\Issue\Stacktrace;

use App\Models\Issue\Occurrence;
use App\Transforms\IsTransformer;
use App\ValueObjects\IsValueObject;
use App\ValueObjects\Issue\StacktraceValueObject;

class IssueStacktraceTransformer implements IsTransformer
{
    /**
     * @var \App\Models\Issue\Occurrence
     */
    private Occurrence $occurrence;

    /**
     * @param mixed $item
     *
     * @return \App\ValueObjects\IsValueObject
     */
    public function transform(mixed $item): IsValueObject
    {
        $obj = new StacktraceValueObject();
        $obj->stacktrace = $item->input('stacktrace');
        $obj->occurrence = $this->occurrence;

        return $obj;
    }

    /**
     * @param \App\Models\Issue\Occurrence $occurrence
     *
     * @return $this
     */
    public function setOccurrence(Occurrence $occurrence): IssueStacktraceTransformer {
        $this->occurrence = $occurrence;

        return $this;
    }
}
