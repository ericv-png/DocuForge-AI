<?php

namespace App\Http\Requests;

use App\Models\Error;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateErrorRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('error_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
            'message' => [
                'string',
                'nullable',
            ],
        ];
    }
}
