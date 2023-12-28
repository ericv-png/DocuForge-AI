<?php

namespace App\Http\Requests;

use App\Models\DataSource;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDataSourceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('data_source_create');
    }

    public function rules()
    {
        return [
            'reference' => [
                'string',
                'required',
                'unique:data_sources',
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
