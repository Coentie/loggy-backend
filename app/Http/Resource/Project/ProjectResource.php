<?php

namespace App\Http\Resource\Project;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Transforms\Issue\AggregateIssuesDatePeriodTransformer;

/**
 * @property-read \App\Models\Project\Project $resource
 */
class ProjectResource extends JsonResource
{
    public function toArray(Request $request)
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'key' => $this->resource->key,
            'slug' => $this->resource->slug,
            'issueAggregate' => AggregateIssuesDatePeriodTransformer::transform(),
            'createdAt' => $this->resource->created_at->format('d-m-Y'),
            'updatedAt' => $this->resource->created_at->format('d-m-Y'),
        ];
    }
}
