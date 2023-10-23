<?php

namespace App\Models\Issue;

use App\Models\Project\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property int $project_id
 * @property string $title
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Issue extends Model
{
    /**
     * An issue belongs to a project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project(): BelongsTo {
        return $this->belongsTo(Project::class);
    }

    /**
     * An issue has may have many occurrences.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function occurrences(): HasMany {
        return $this->hasMany(Occurrence::class);
    }
}
