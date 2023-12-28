<?php

namespace App\Http\Requests;

use App\Models\QueryMessage;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyQueryMessageRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('query_message_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:query_messages,id',
        ];
    }
}
