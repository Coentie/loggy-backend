<?php

namespace App\ValueObjects\Issue;

use App\Models\Project\Project;
use App\ValueObjects\IsValueObject;

class IssueValueObject implements IsValueObject
{
    /**
     * @var \App\Models\Project\Project
     */
    public Project $project;

    /**
     * @var string
     */
    public string $title;
}
