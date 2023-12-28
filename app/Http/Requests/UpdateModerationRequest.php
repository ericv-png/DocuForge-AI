<?php

namespace App\Http\Requests;

use App\Models\Moderation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateModerationRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('moderation_edit');
    }

    public function rules()
    {
        return [];
    }
}
