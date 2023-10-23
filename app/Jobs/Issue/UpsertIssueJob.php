<?php

namespace App\Jobs\Issue;

use App\Models\Issue\Issue;
use App\Models\Project\Project;
use App\ValueObjects\Issue\IssueValueObject;

class UpsertIssueJob extends BaseIssueJob
{
    /**
     * Handles the job.
     *
     * @return Project
     */
    public function handle(): Issue {
        $i = $this->model();

        if($this->exists) return $i;

        $i->title = $this->obj->title;
        $i->project_id = $this->obj->project->id;
        $i->save();

        return $i;
    }
}
