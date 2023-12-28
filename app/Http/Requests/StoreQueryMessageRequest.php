<?php

namespace App\Http\Requests;

use App\Models\QueryMessage;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreQueryMessageRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('query_message_create');
    }

    public function rules()
    {
        return [
            'reference' => [
                'string',
                'required',
                'unique:query_messages',
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
