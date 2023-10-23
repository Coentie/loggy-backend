<?php

namespace App\Transforms\Project;

use Illuminate\Support\Str;
use App\Models\Project\Project;
use App\Transforms\IsTransformer;
use App\ValueObjects\IsValueObject;
use App\ValueObjects\Project\ProjectValueObject;

class StoreProjectRequestTransformer implements IsTransformer
{
    /**
     * Transforms the request into a value object.
     *
     * @param \App\Http\Requests\Project\ProjectRequest $item
     *
     * @return \App\ValueObjects\IsValueObject
     */
    public function transform(mixed $item): IsValueObject
    {
        $obj = new ProjectValueObject();
        $obj->name = $item->input('name');
        $obj->slug = Str::slug($item->input('name'));
        $obj->key = Project::generateKey();
        return $obj;
    }
}
