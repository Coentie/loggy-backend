<?php

namespace App\Http\Resource\Issue;

use Illuminate\Http\Request;
use App\Models\Issue\Occurrence;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resource\Occurrence\OccurrenceResource;
use App\Http\Resource\Issue\Stacktrace\StacktraceResource;

/**
 * @property \App\Models\Issue\Issue $resource
 */
class IssueResource extends JsonResource
{
    public function toArray(Request $request)
    {
        /** @var \App\Models\Issue\Occurrence $occurrence */
        $occurrence = $this->resource->occurrences()->latest()->first();

        return [
            'title' => $this->resource->title,
            'occurrence' => new OccurrenceResource($occurrence),
        ];
    }
}
