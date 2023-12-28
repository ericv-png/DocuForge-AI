@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.queryMessage.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.query-messages.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="reference">{{ trans('cruds.queryMessage.fields.reference') }}</label>
                <input class="form-control {{ $errors->has('reference') ? 'is-invalid' : '' }}" type="text" name="reference" id="reference" value="{{ old('reference', '') }}" required>
                @if($errors->has('reference'))
                    <div class="invalid-feedback">
                        {{ $errors->first('reference') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.queryMessage.fields.reference_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.queryMessage.fields.type') }}</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type">
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\QueryMessage::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('type', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.queryMessage.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="query_id">{{ trans('cruds.queryMessage.fields.query') }}</label>
                <select class="form-control select2 {{ $errors->has('query') ? 'is-invalid' : '' }}" name="query_id" id="query_id">
                    @foreach($queries as $id => $entry)
                        <option value="{{ $id }}" {{ old('query_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('query'))
                    <div class="invalid-feedback">
                        {{ $errors->first('query') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.queryMessage.fields.query_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="message">{{ trans('cruds.queryMessage.fields.message') }}</label>
                <textarea class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}" name="message" id="message">{{ old('message') }}</textarea>
                @if($errors->has('message'))
                    <div class="invalid-feedback">
                        {{ $errors->first('message') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.queryMessage.fields.message_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="report_id">{{ trans('cruds.queryMessage.fields.report') }}</label>
                <select class="form-control select2 {{ $errors->has('report') ? 'is-invalid' : '' }}" name="report_id" id="report_id">
                    @foreach($reports as $id => $entry)
                        <option value="{{ $id }}" {{ old('report_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('report'))
                    <div class="invalid-feedback">
                        {{ $errors->first('report') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.queryMessage.fields.report_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tokens">{{ trans('cruds.queryMessage.fields.tokens') }}</label>
                <input class="form-control {{ $errors->has('tokens') ? 'is-invalid' : '' }}" type="number" name="tokens" id="tokens" value="{{ old('tokens', '') }}" step="1">
                @if($errors->has('tokens'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tokens') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.queryMessage.fields.tokens_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="ai_model">{{ trans('cruds.queryMessage.fields.ai_model') }}</label>
                <input class="form-control {{ $errors->has('ai_model') ? 'is-invalid' : '' }}" type="text" name="ai_model" id="ai_model" value="{{ old('ai_model', '') }}">
                @if($errors->has('ai_model'))
                    <div class="invalid-feedback">
                        {{ $errors->first('ai_model') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.queryMessage.fields.ai_model_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection