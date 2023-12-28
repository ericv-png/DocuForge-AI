<?php

namespace App\Http\Requests;

use App\Models\ExtractedData;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyExtractedDataRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('extracted_data_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:extracted_datas,id',
        ];
    }
}
