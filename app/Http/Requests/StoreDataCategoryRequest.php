<?php

namespace App\Http\Requests;

use App\Models\DataCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDataCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('data_category_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
        ];
    }
}
