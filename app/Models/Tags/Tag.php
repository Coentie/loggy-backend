<?php

namespace App\Models\Tags;

use App\Models\Issue\Occurrence;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @property-read int $id
 * @property string $title
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Tag extends Model
{
    /**
     * A tag can belong to many occurrences.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function occurrence(): MorphToMany {
        return $this->morphedByMany(Occurrence::class, 'taggable');
    }
}
