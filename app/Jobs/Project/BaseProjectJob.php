<?php

namespace App\Jobs\Project;

use App\Models\Project\Project;
use App\ValueObjects\Project\ProjectValueObject;

abstract class BaseProjectJob
{
    /**
     * Base project transformer.
     *
     * @param \App\ValueObjects\Project\ProjectValueObject $obj
     */
    public final function __construct(protected ProjectValueObject $obj) {}

    /**
     * Fetches the model.
     *
     * @return \App\Models\Project\Project
     */
    protected final function model(): Project {
        $project = Project::query()
               ->where('name', '=', $this->obj->name)
               ->first();

        return $project ?? new Project();
    }
}
