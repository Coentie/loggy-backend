<?php

namespace App\Jobs\Issue;

use App\Models\Issue\Issue;
use App\ValueObjects\Issue\IssueValueObject;

abstract class BaseIssueJob
{
    /**
     * Variable that holds if the model already exists
     *
     * @var bool
     */
    protected bool $exists = false;

    /**
     * Base project transformer.
     *
     * @param \App\ValueObjects\Issue\IssueValueObject $obj
     */
    public final function __construct(protected IssueValueObject $obj)
    {
    }

    /**
     * Fetches the model.
     *
     * @return \App\Models\Issue\Issue
     */
    protected final function model(): Issue
    {
        $issue = Issue::query()
                      ->where('title', '=', $this->obj->title)
                      ->where('project_id', '=', $this->obj->project->id)
                      ->first();

        if($issue instanceof Issue) {
            $this->exists = true;
            return $issue;
        }

        return new Issue();
    }
}
