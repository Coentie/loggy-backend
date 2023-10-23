<?php

namespace DeepDigital\Loggy\Hub;

use Throwable;

interface HubInterface
{
    public function captureException(Throwable $exception, $hint);
}
