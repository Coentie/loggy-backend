<?php

namespace DeepDigital\Loggy\Project;

class Project implements ProjectInterface
{
    public function register(): bool
    {
        // TODO: Implement register() method.
    }

    /**
     * Generates a random name for a project..
     *
     * @return string
     */
    public static function generateRandomName(): string {
        $timestamp = time();
        $randomString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 10);
        $name = $timestamp . $randomString;
        while (strlen($name) < 26) {
            $name .= mt_rand(0, 9);
        }
        return $name;
    }
}
