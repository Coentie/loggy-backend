<?php

namespace App\Models\Issue;

use App\Models\Tags\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property int $id
 * @property int $issue_id
 * @property string $language
 * @property string $language_version
 * @property string $operating_system
 * @property string $operating_version
 * @property string $operating_release
 * @property string $environment
 * @property string|null $username
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property-read \App\Models\Issue\Stacktrace $stacktrace
 * @property-read \App\Models\Issue\Issue $issue
 */
class Occurrence extends Model
{
    /**
     * An occurrence belongs to an issue.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function issue(): BelongsTo {
        return $this->belongsTo(Issue::class);
    }

    /**
     * An event has one stacktrace.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function stacktrace(): HasOne {
        return $this->hasOne(Stacktrace::class);
    }

    /**
     * An occurrence can have many tags.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tags(): MorphToMany {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
