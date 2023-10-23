<?php

namespace App\Transforms\Issue;

use App\Models\Project\Project;
use App\Transforms\IsTransformer;
use App\ValueObjects\IsValueObject;
use App\ValueObjects\Issue\IssueValueObject;

class IssueRequestTransformer implements IsTransformer
{
    /**
     * @var \App\Models\Project\Project
     */
    private Project $project;

    /**
     * @param \App\Http\Requests\Issue\IssueRequest $item
     *
     * @return \App\ValueObjects\IsValueObject
     */
    public function transform(mixed $item): IsValueObject
    {
        $obj = new IssueValueObject();
        $obj->project = $this->project;
        $obj->title = $item->input('title');

        return $obj;
    }

    /**
     * Sets the project
     *
     * @param \App\Models\Project\Project $project
     *
     * @return $this
     */
    public function setProject(Project $project): IssueRequestTransformer {
        $this->project = $project;

        return $this;
    }
}
