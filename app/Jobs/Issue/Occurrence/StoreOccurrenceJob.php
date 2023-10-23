<?php

namespace App\Jobs\Issue\Occurrence;

use App\Models\Issue\Occurrence;
use App\ValueObjects\Issue\OccurrenceValueObject;

class StoreOccurrenceJob
{
    /**
     * StoreOccurrenceJob
     *
     * @param \App\ValueObjects\Issue\OccurrenceValueObject $obj
     */
    public function __construct(public OccurrenceValueObject $obj) {}

    /**
     * Handle the jobs.
     *
     * @return \App\Models\Issue\Occurrence
     */
    public function handle(): Occurrence {
        $occ = new Occurrence();
        $occ->issue()->associate($this->obj->issue);
        $occ->language = $this->obj->language;
        $occ->language_version = $this->obj->languageVersion;
        $occ->operating_release= $this->obj->operatingRelease;
        $occ->operating_version = $this->obj->operatingVersion;
        $occ->operating_system = $this->obj->operatingSystem;
        $occ->environment = $this->obj->environment;
        $occ->username = $this->obj->username;
        $occ->save();

        return $occ;
    }
}
