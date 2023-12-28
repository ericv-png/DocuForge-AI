@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.moderation.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.moderations.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="query_message_id">{{ trans('cruds.moderation.fields.query_message') }}</label>
                <select class="form-control select2 {{ $errors->has('query_message') ? 'is-invalid' : '' }}" name="query_message_id" id="query_message_id">
                    @foreach($query_messages as $id => $entry)
                        <option value="{{ $id }}" {{ old('query_message_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('query_message'))
                    <div class="invalid-feedback">
                        {{ $errors->first('query_message') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.moderation.fields.query_message_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="data_source_id">{{ trans('cruds.moderation.fields.data_source') }}</label>
                <select class="form-control select2 {{ $errors->has('data_source') ? 'is-invalid' : '' }}" name="data_source_id" id="data_source_id">
                    @foreach($data_sources as $id => $entry)
                        <option value="{{ $id }}" {{ old('data_source_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('data_source'))
                    <div class="invalid-feedback">
                        {{ $errors->first('data_source') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.moderation.fields.data_source_helper') }}</span>
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