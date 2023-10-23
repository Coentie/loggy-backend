<?php

namespace App\Http\Resource\Occurrence;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resource\Issue\Stacktrace\StacktraceResource;

/**
 * @property \App\Models\Issue\Occurrence $resource
 */
class OccurrenceResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->resource->id,
            'language' => $this->resource->language,
            'username' => $this->resource->username,
            'environment' => $this->resource->environment,
            'language_version' => $this->resource->language_version,
            'operating_release' => $this->resource->operating_release,
            'operating_version' => $this->resource->operating_version,
            'operating_system' => $this->resource->operating_system,
            'stacktrace' => new StacktraceResource($this->resource->stacktrace),
        ];
    }
}
