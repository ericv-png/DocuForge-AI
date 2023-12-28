<?php

namespace App\Http\Requests;

use App\Models\DataCategory;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyDataCategoryRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('data_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:data_categories,id',
        ];
    }
}
