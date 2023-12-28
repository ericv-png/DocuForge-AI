<?php

namespace App\Http\Requests;

use App\Models\DataSource;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateDataSourceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('data_source_edit');
    }

    public function rules()
    {
        return [
            'reference' => [
                'string',
                'required',
                'unique:data_sources,reference,' . request()->route('data_source')->id,
            ],
            'name' => [
                'string',
                'nullable',
            ],
            'categories.*' => [
                'integer',
            ],
            'categories' => [
                'array',
            ],
            'type' => [
                'required',
            ],
            'url' => [
                'string',
                'nullable',
            ],
        ];
    }
}
