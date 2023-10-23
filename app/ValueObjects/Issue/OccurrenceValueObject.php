<?php

namespace App\ValueObjects\Issue;

use App\Models\Issue\Issue;
use App\ValueObjects\IsValueObject;

class OccurrenceValueObject implements IsValueObject
{
    /**
     * @var \App\Models\Issue\Issue
     */
    public Issue $issue;

    /**
     * @var string
     */
    public string $language;

    /**
     * @var string
     */
    public string $languageVersion;

    /**
     * @var string
     */
    public string $operatingSystem;

    /**
     * @var string
     */
    public string $operatingVersion;

    /**
     * @var string
     */
    public string $operatingRelease;

    /**
     * @var string
     */
    public string $environment;

    /**
     * @var string|null
     */
    public ?string $username = null;

}
