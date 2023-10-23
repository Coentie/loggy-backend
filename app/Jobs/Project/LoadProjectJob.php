<?php

namespace App\Jobs\Project;

use App\Models\Project\Project;
use Illuminate\Support\Collection;

class LoadProjectJob
{
    /**
     * Handles the job
     *
     * @return \Illuminate\Support\Collection
     */
    public function handle(): Collection {
        return Project::query()
            ->get();
    }
}
