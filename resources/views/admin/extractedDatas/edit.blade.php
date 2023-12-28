@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.extractedData.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.extracted-datas.update", [$extractedData->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="source_file_id">{{ trans('cruds.extractedData.fields.source_file') }}</label>
                <select class="form-control select2 {{ $errors->has('source_file') ? 'is-invalid' : '' }}" name="source_file_id" id="source_file_id" required>
                    @foreach($source_files as $id => $entry)
                        <option value="{{ $id }}" {{ (old('source_file_id') ? old('source_file_id') : $extractedData->source_file->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('source_file'))
                    <div class="invalid-feedback">
                        {{ $errors->first('source_file') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.extractedData.fields.source_file_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="excerpt">{{ trans('cruds.extractedData.fields.excerpt') }}</label>
                <input class="form-control {{ $errors->has('excerpt') ? 'is-invalid' : '' }}" type="text" name="excerpt" id="excerpt" value="{{ old('excerpt', $extractedData->excerpt) }}">
                @if($errors->has('excerpt'))
                    <div class="invalid-feedback">
                        {{ $errors->first('excerpt') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.extractedData.fields.excerpt_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="summary">{{ trans('cruds.extractedData.fields.summary') }}</label>
                <textarea class="form-control {{ $errors->has('summary') ? 'is-invalid' : '' }}" name="summary" id="summary">{{ old('summary', $extractedData->summary) }}</textarea>
                @if($errors->has('summary'))
                    <div class="invalid-feedback">
                        {{ $errors->first('summary') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.extractedData.fields.summary_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="extracted_data">{{ trans('cruds.extractedData.fields.extracted_data') }}</label>
                <textarea class="form-control {{ $errors->has('extracted_data') ? 'is-invalid' : '' }}" name="extracted_data" id="extracted_data" required>{{ old('extracted_data', $extractedData->extracted_data) }}</textarea>
                @if($errors->has('extracted_data'))
                    <div class="invalid-feedback">
                        {{ $errors->first('extracted_data') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.extractedData.fields.extracted_data_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="tokens">{{ trans('cruds.extractedData.fields.tokens') }}</label>
                <input class="form-control {{ $errors->has('tokens') ? 'is-invalid' : '' }}" type="number" name="tokens" id="tokens" value="{{ old('tokens', $extractedData->tokens) }}" step="1">
                @if($errors->has('tokens'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tokens') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.extractedData.fields.tokens_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="ai_model">{{ trans('cruds.extractedData.fields.ai_model') }}</label>
                <input class="form-control {{ $errors->has('ai_model') ? 'is-invalid' : '' }}" type="text" name="ai_model" id="ai_model" value="{{ old('ai_model', $extractedData->ai_model) }}">
                @if($errors->has('ai_model'))
                    <div class="invalid-feedback">
                        {{ $errors->first('ai_model') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.extractedData.fields.ai_model_helper') }}</span>
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