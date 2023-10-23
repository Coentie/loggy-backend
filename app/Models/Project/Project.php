<?php

namespace App\Models\Project;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property string $name
 * @property string $slug
 * @property string $key
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Project extends Model
{
    public const KEY_PREFIX = 'LOGGY';

    /**
     * Generates a key for a new project
     *
     * @return string
     */
    public static function generateKey() {
        return Hash::make(self::KEY_PREFIX . '_' . Carbon::now()->unix(), [
            'round' => 12
        ]);
    }
}
