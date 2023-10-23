<?php

namespace App\Transforms\Issue\Occurrence;

use App\Models\Issue\Issue;
use App\Transforms\IsTransformer;
use App\ValueObjects\IsValueObject;
use App\ValueObjects\Issue\OccurrenceValueObject;

class IssueOccurrenceTransformer implements IsTransformer
{
    /**
     * @var \App\Models\Issue\Issue
     */
    private Issue $issue;

    /**
     * @param mixed $item
     *
     * @return \App\ValueObjects\IsValueObject
     */
    public function transform(mixed $item): IsValueObject
    {
        $obj = new OccurrenceValueObject();
        $obj->issue = $this->issue;

        // Adding meta data to the occurrence.
        $obj->environment = $item['meta']['environment'];
        $obj->language = $item['meta']['language'];
        $obj->languageVersion = $item['meta']['languageVersion'];
        $obj->operatingSystem = $item['meta']['operatingSystem'];
        $obj->operatingVersion = $item['meta']['operatingVersion'];
        $obj->operatingRelease = $item['meta']['operatingRelease'];
        $obj->username = $item['meta']['authenticatedUser'];

        return $obj;
    }

    /**
     * Sets the issue.
     *
     * @param \App\Models\Issue\Issue $issue
     *
     * @return $this
     */
    public function setIssue(Issue $issue): IssueOccurrenceTransformer {
        $this->issue = $issue;

        return $this;
    }
}
