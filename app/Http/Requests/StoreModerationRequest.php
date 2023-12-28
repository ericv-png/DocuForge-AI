<?php

namespace App\Http\Requests;

use App\Models\Moderation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreModerationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('moderation_create');
    }

    public function rules()
    {
        return [];
    }
}
