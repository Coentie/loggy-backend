<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

abstract class BaseSeeder extends Seeder
{
    /**
     * Checks if a given class instance already exists.
     *
     * @param \Illuminate\Database\Eloquent\Model $class
     * @param                                     $column
     * @param                                     $key
     *
     * @return bool
     *
     */
    protected function exists(Model $class, $column, $key) {
        return $class::query()
            ->where($column, $key)
            ->exists();
    }
}
