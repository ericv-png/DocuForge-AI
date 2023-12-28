@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.report.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.reports.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label class="required" for="reference">{{ trans('cruds.report.fields.reference') }}</label>
                            <input class="form-control" type="text" name="reference" id="reference" value="{{ old('reference', '') }}" required>
                            @if($errors->has('reference'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('reference') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.report.fields.reference_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="name">{{ trans('cruds.report.fields.name') }}</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{ old('name', '') }}">
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.report.fields.name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="description">{{ trans('cruds.report.fields.description') }}</label>
                            <input class="form-control" type="text" name="description" id="description" value="{{ old('description', '') }}">
                            @if($errors->has('description'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('description') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.report.fields.description_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="query_id">{{ trans('cruds.report.fields.query') }}</label>
                            <select class="form-control select2" name="query_id" id="query_id">
                                @foreach($queries as $id => $entry)
                                    <option value="{{ $id }}" {{ old('query_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('query'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('query') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.report.fields.query_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="query_message_id">{{ trans('cruds.report.fields.query_message') }}</label>
                            <select class="form-control select2" name="query_message_id" id="query_message_id">
                                @foreach($query_messages as $id => $entry)
                                    <option value="{{ $id }}" {{ old('query_message_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('query_message'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('query_message') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.report.fields.query_message_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="generated_file">{{ trans('cruds.report.fields.generated_file') }}</label>
                            <div class="needsclick dropzone" id="generated_file-dropzone">
                            </div>
                            @if($errors->has('generated_file'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('generated_file') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.report.fields.generated_file_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('cruds.report.fields.status') }}</label>
                            <select class="form-control" name="status" id="status">
                                <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Report::STATUS_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('status') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.report.fields.status_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="tokens">{{ trans('cruds.report.fields.tokens') }}</label>
                            <input class="form-control" type="number" name="tokens" id="tokens" value="{{ old('tokens', '') }}" step="1">
                            @if($errors->has('tokens'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('tokens') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.report.fields.tokens_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="ai_model">{{ trans('cruds.report.fields.ai_model') }}</label>
                            <input class="form-control" type="text" name="ai_model" id="ai_model" value="{{ old('ai_model', '') }}">
                            @if($errors->has('ai_model'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('ai_model') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.report.fields.ai_model_helper') }}</span>
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

@section('scripts')
<script>
    var uploadedGeneratedFileMap = {}
Dropzone.options.generatedFileDropzone = {
    url: '{{ route('frontend.reports.storeMedia') }}',
    maxFilesize: 100, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 100
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="generated_file[]" value="' + response.name + '">')
      uploadedGeneratedFileMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedGeneratedFileMap[file.name]
      }
      $('form').find('input[name="generated_file[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($report) && $report->generated_file)
          var files =
            {!! json_encode($report->generated_file) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="generated_file[]" value="' + file.file_name + '">')
            }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}
</script>
@endsection