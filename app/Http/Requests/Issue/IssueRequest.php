<?php

namespace App\Http\Requests\Issue;

use App\Models\Project\Project;
use Illuminate\Foundation\Http\FormRequest;

class IssueRequest extends FormRequest
{
    /**
     * Authorizes the request.
     *
     * @return true
     */
    public function authorize() {
        return true;
    }

    /**
     * Rules of the request.
     *
     * @return string[]
     */
    public function rules(): array {
        return [
            'title' => 'required|string',
            'stacktrace' => 'required|string',
            'key' => 'required|exists:projects,key',
        ];
    }

    /**
     * Handle a passed validation attempt.
     */
    protected function passedValidation(): void
    {
        $project = Project::query()
            ->where('key', '=', $this->input('key'))
            ->first();

        $this->merge(['project' => $project]);
    }
}
