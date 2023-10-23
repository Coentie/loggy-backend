<?php

namespace App\ValueObjects\Project;

use App\ValueObjects\IsValueObject;

class ProjectValueObject implements IsValueObject
{
    /**
     * Name of the project.
     *
     * @var string
     */
    public string $name;

    /**
     * Slug of the project
     *
     * @var string
     */
    public string $slug;

    /**
     * Unique key of the project.
     *
     * @var string
     */
    public string $key;
}
