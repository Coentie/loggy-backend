<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    /**
     * Authorizes the request.
     *
     * @return true
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Fetches the rules of the request.
     *
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'min:3',
                'max:255',
            ],
        ];
    }
}
