<?php

namespace DeepDigital\Loggy;

use DeepDigital\Loggy\Hub\Hub;
use DeepDigital\Loggy\Project\Project;
use DeepDigital\Loggy\Intergration\IntergrationInterface;

class Loggy implements IntergrationInterface
{
    /**
     * Env key to set the project key to.
     */
    public const PROJECT_ENV_KEY = 'LOGGY_PROJECT_KEY';

    /**
     * Loggy constructor.
     *
     * @param \DeepDigital\Loggy\Hub\Hub         $hub
     * @param \DeepDigital\Loggy\Project\Project $project
     */
    public function __construct(Hub $hub, Project $project) {
        $this->hub = $hub;
        $this->project = $this->project;
    }

    /**
     * Try to make an educated guess if the call came from the Laravel `report` helper.
     *
     * @return bool
     */
    private static function makeAnEducatedGuessIfTheExceptionMaybeWasHandled(): bool
    {
        // We limit the amount of backtrace frames since it is very unlikely to be any deeper
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 20);

        // We are looking for `$handler->report()` to be called from the `report()` function
        foreach ($trace as $frameIndex => $frame) {
            // We need a frame with a class and function defined, we can skip frames missing either
            if (!isset($frame['class'], $frame['function'])) {
                continue;
            }

            // Check if the frame was indeed `$handler->report()`
            if ($frame['type'] !== '->' || $frame['function'] !== 'report') {
                continue;
            }

            // Make sure we have a next frame, we could have reached the end of the trace
            if (!isset($trace[$frameIndex + 1])) {
                continue;
            }

            // The next frame should contain the call to the `report()` helper function
            $nextFrame = $trace[$frameIndex + 1];

            // If a class was set or the function name is not `report` we can skip this frame
            if (isset($nextFrame['class']) || !isset($nextFrame['function']) || $nextFrame['function'] !== 'report') {
                continue;
            }

            // If we reached this point we can be pretty sure the `report` function was called
            // and we can come to the educated conclusion the exception was indeed handled
            return true;
        }

        // If we reached this point we can be pretty sure the `report` function was not called
        return false;
    }

    public static function captureUnhandledException(\Throwable $e)
    {
    }

    public static function captureMessage(string $message, mixed $data)
    {
        // TODO: Implement captureMessage() method.
    }
}
