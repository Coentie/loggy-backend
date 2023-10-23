<?php

namespace App\Http\Resource\Issue\Stacktrace;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Issue\Stacktrace $resource
 */
class StacktraceResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'trace' => json_decode($this->resource->trace),
        ];
    }
}
