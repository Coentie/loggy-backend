<?php

namespace App\Models\Issue;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property int $occurrence_id
 * @property array $trace
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Stacktrace extends Model
{
    /**
     * Attributes that should be cast to native types.
     *
     * @var string[]
     */
    public $casts = [
        'trace' => 'array'
    ];

    /**
     * A stacktrace belongs to an occurrence
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function occurrence(): BelongsTo {
        return $this->belongsTo(Occurrence::class);
    }
}
