<?php

namespace DeepDigital\Loggy\Intergration;

interface IntergrationInterface
{
    /**
     * Captures unhandled exception
     *
     * @param \Throwable $e
     *
     * @return mixed
     */
    public static function captureUnhandledException(\Throwable $e);

    /**
     * Captures messages as part of a logging system.
     *
     * @param string $message
     * @param mixed  $data
     *
     * @return mixed
     */
    public static function captureMessage(string $message, mixed $data);
}
