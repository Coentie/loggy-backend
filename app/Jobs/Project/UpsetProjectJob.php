<?php

namespace App\Jobs\Project;

use App\Models\Project\Project;

class UpsetProjectJob extends BaseProjectJob
{
    /**
     * Handles the job.
     *
     * @return Project
     */
    public function handle(): Project {
        $p = $this->model();
        $p->name = $this->obj->name;
        $p->slug = $this->obj->slug;
        $p->key = $this->obj->key;
        $p->save();

        return $p;
    }
}
