<?php

namespace App\Console\Commands\Tests;

use App\Models\Issue\Issue;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CreateTestIssueCommand extends Command
{
    /**
     * @var string
     */
    public $signature = 'tests:create-test-issue';

    /**
     * @var string
     */
    public $description = 'Creates a test issue';

    public function handle() {
        try {
            $issue = Issue::query()->findOrFail(0);
        }catch (\Exception $e) {
            $res = Http::post(env('APP_URL') . '/api/issues', [
                'title' => $e->getMessage(),
                'key' => env('LOGGY_PROJECT_KEY'),
                'stacktrace' => json_encode($e->getTrace()),
                'meta' => [
                    'language' => 'PHP',
                    'environment' => env('APP_ENV'),
                    'languageVersion' => phpversion(),
                    'operatingSystem' => php_uname('s'),
                    'operatingVersion' =>  php_uname('v'),
                    'operatingRelease' =>  php_uname('r'),
                    'authenticatedUser' => auth()->check() ? auth()->user->name : null,
                ]
            ]);

            dd($res->body());
        }
    }
}

