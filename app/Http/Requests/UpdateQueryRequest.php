<?php

namespace App\Http\Requests;

use App\Models\Query;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateQueryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('query_edit');
    }

    public function rules()
    {
        return [
            'reference' => [
                'string',
                'required',
                'unique:queries,reference,' . request()->route('query')->id,
            ],
            'name' => [
                'string',
                'required',
            ],
            'data_sources.*' => [
                'integer',
            ],
            'data_sources' => [
                'array',
            ],
        ];
    }
}
