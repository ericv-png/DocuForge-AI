@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.query.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.queries.update", [$query->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="reference">{{ trans('cruds.query.fields.reference') }}</label>
                            <input class="form-control" type="text" name="reference" id="reference" value="{{ old('reference', $query->reference) }}" required>
                            @if($errors->has('reference'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('reference') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.query.fields.reference_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="name">{{ trans('cruds.query.fields.name') }}</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $query->name) }}" required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.query.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="data_sources">{{ trans('cruds.query.fields.data_source') }}</label>
                            <div style="padding-bottom: 4px">
                                <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                                <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                            </div>
                            <select class="form-control select2" name="data_sources[]" id="data_sources" multiple>
                                @foreach($data_sources as $id => $data_source)
                                    <option value="{{ $id }}" {{ (in_array($id, old('data_sources', [])) || $query->data_sources->contains($id)) ? 'selected' : '' }}>{{ $data_source }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('data_sources'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('data_sources') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.query.fields.data_source_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <div>
                                <input type="hidden" name="encrypted" value="0">
                                <input type="checkbox" name="encrypted" id="encrypted" value="1" {{ $query->encrypted || old('encrypted', 0) === 1 ? 'checked' : '' }}>
                                <label for="encrypted">{{ trans('cruds.query.fields.encrypted') }}</label>
                            </div>
                            @if($errors->has('encrypted'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('encrypted') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.query.fields.encrypted_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection