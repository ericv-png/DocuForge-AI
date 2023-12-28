<?php

namespace App\Http\Requests;

use App\Models\Setting;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSettingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('setting_create');
    }

    public function rules()
    {
        return [
            'org_name' => [
                'string',
                'nullable',
            ],
            'ai_service_provider_credentials' => [
                'string',
                'nullable',
            ],
            'ai_processing_model' => [
                'string',
                'nullable',
            ],
            'image_file_processing_model' => [
                'string',
                'nullable',
            ],
            'text_file_processing_model' => [
                'string',
                'nullable',
            ],
            'host_url' => [
                'string',
                'nullable',
            ],
            'max_report_simu_process' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'max_data_source_simu_process' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
