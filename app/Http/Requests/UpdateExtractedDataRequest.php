<?php

namespace App\Http\Requests;

use App\Models\ExtractedData;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateExtractedDataRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('extracted_data_edit');
    }

    public function rules()
    {
        return [
            'source_file_id' => [
                'required',
                'integer',
            ],
            'excerpt' => [
                'string',
                'nullable',
            ],
            'extracted_data' => [
                'required',
            ],
            'tokens' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'ai_model' => [
                'string',
                'nullable',
            ],
        ];
    }
}
