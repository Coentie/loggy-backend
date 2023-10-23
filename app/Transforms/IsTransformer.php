<?php

namespace App\Transforms;

use App\ValueObjects\IsValueObject;

interface IsTransformer
{
    /**
     * @param mixed $item
     *
     * @return \App\ValueObjects\IsValueObject
     */
    public function transform(mixed $item): IsValueObject;
}
