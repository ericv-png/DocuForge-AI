@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.setting.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.settings.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label for="org_name">{{ trans('cruds.setting.fields.org_name') }}</label>
                            <input class="form-control" type="text" name="org_name" id="org_name" value="{{ old('org_name', '') }}">
                            @if($errors->has('org_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('org_name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.setting.fields.org_name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="org_logo">{{ trans('cruds.setting.fields.org_logo') }}</label>
                            <div class="needsclick dropzone" id="org_logo-dropzone">
                            </div>
                            @if($errors->has('org_logo'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('org_logo') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.setting.fields.org_logo_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="footer_text">{{ trans('cruds.setting.fields.footer_text') }}</label>
                            <textarea class="form-control ckeditor" name="footer_text" id="footer_text">{!! old('footer_text') !!}</textarea>
                            @if($errors->has('footer_text'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('footer_text') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.setting.fields.footer_text_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <div>
                                <input type="hidden" name="registration_admin_approve" value="0">
                                <input type="checkbox" name="registration_admin_approve" id="registration_admin_approve" value="1" {{ old('registration_admin_approve', 0) == 1 || old('registration_admin_approve') === null ? 'checked' : '' }}>
                                <label for="registration_admin_approve">{{ trans('cruds.setting.fields.registration_admin_approve') }}</label>
                            </div>
                            @if($errors->has('registration_admin_approve'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('registration_admin_approve') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.setting.fields.registration_admin_approve_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('cruds.setting.fields.ai_service_provider') }}</label>
                            <select class="form-control" name="ai_service_provider" id="ai_service_provider">
                                <option value disabled {{ old('ai_service_provider', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Setting::AI_SERVICE_PROVIDER_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('ai_service_provider', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('ai_service_provider'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('ai_service_provider') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.setting.fields.ai_service_provider_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="ai_service_provider_credentials">{{ trans('cruds.setting.fields.ai_service_provider_credentials') }}</label>
                            <input class="form-control" type="text" name="ai_service_provider_credentials" id="ai_service_provider_credentials" value="{{ old('ai_service_provider_credentials', '') }}">
                            @if($errors->has('ai_service_provider_credentials'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('ai_service_provider_credentials') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.setting.fields.ai_service_provider_credentials_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="ai_processing_model">{{ trans('cruds.setting.fields.ai_processing_model') }}</label>
                            <input class="form-control" type="text" name="ai_processing_model" id="ai_processing_model" value="{{ old('ai_processing_model', '') }}">
                            @if($errors->has('ai_processing_model'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('ai_processing_model') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.setting.fields.ai_processing_model_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <div>
                                <input type="hidden" name="api_status" value="0">
                                <input type="checkbox" name="api_status" id="api_status" value="1" {{ old('api_status', 0) == 1 || old('api_status') === null ? 'checked' : '' }}>
                                <label for="api_status">{{ trans('cruds.setting.fields.api_status') }}</label>
                            </div>
                            @if($errors->has('api_status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('api_status') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.setting.fields.api_status_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('cruds.setting.fields.image_file_processing') }}</label>
                            <select class="form-control" name="image_file_processing" id="image_file_processing">
                                <option value disabled {{ old('image_file_processing', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Setting::IMAGE_FILE_PROCESSING_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('image_file_processing', 'local') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('image_file_processing'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('image_file_processing') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.setting.fields.image_file_processing_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="image_file_processing_model">{{ trans('cruds.setting.fields.image_file_processing_model') }}</label>
                            <input class="form-control" type="text" name="image_file_processing_model" id="image_file_processing_model" value="{{ old('image_file_processing_model', '') }}">
                            @if($errors->has('image_file_processing_model'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('image_file_processing_model') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.setting.fields.image_file_processing_model_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="image_file_processing_credentials">{{ trans('cruds.setting.fields.image_file_processing_credentials') }}</label>
                            <textarea class="form-control" name="image_file_processing_credentials" id="image_file_processing_credentials">{{ old('image_file_processing_credentials') }}</textarea>
                            @if($errors->has('image_file_processing_credentials'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('image_file_processing_credentials') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.setting.fields.image_file_processing_credentials_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('cruds.setting.fields.text_file_processing') }}</label>
                            <select class="form-control" name="text_file_processing" id="text_file_processing">
                                <option value disabled {{ old('text_file_processing', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Setting::TEXT_FILE_PROCESSING_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('text_file_processing', 'local') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('text_file_processing'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('text_file_processing') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.setting.fields.text_file_processing_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="text_file_processing_model">{{ trans('cruds.setting.fields.text_file_processing_model') }}</label>
                            <input class="form-control" type="text" name="text_file_processing_model" id="text_file_processing_model" value="{{ old('text_file_processing_model', '') }}">
                            @if($errors->has('text_file_processing_model'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('text_file_processing_model') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.setting.fields.text_file_processing_model_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="text_file_processing_credentials">{{ trans('cruds.setting.fields.text_file_processing_credentials') }}</label>
                            <textarea class="form-control" name="text_file_processing_credentials" id="text_file_processing_credentials">{{ old('text_file_processing_credentials') }}</textarea>
                            @if($errors->has('text_file_processing_credentials'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('text_file_processing_credentials') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.setting.fields.text_file_processing_credentials_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="mail_credentials">{{ trans('cruds.setting.fields.mail_credentials') }}</label>
                            <textarea class="form-control" name="mail_credentials" id="mail_credentials">{{ old('mail_credentials') }}</textarea>
                            @if($errors->has('mail_credentials'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('mail_credentials') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.setting.fields.mail_credentials_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="host_url">{{ trans('cruds.setting.fields.host_url') }}</label>
                            <input class="form-control" type="text" name="host_url" id="host_url" value="{{ old('host_url', '') }}">
                            @if($errors->has('host_url'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('host_url') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.setting.fields.host_url_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <div>
                                <input type="hidden" name="moderation" value="0">
                                <input type="checkbox" name="moderation" id="moderation" value="1" {{ old('moderation', 0) == 1 || old('moderation') === null ? 'checked' : '' }}>
                                <label for="moderation">{{ trans('cruds.setting.fields.moderation') }}</label>
                            </div>
                            @if($errors->has('moderation'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('moderation') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.setting.fields.moderation_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <div>
                                <input type="hidden" name="registration" value="0">
                                <input type="checkbox" name="registration" id="registration" value="1" {{ old('registration', 0) == 1 || old('registration') === null ? 'checked' : '' }}>
                                <label for="registration">{{ trans('cruds.setting.fields.registration') }}</label>
                            </div>
                            @if($errors->has('registration'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('registration') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.setting.fields.registration_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="max_report_simu_process">{{ trans('cruds.setting.fields.max_report_simu_process') }}</label>
                            <input class="form-control" type="number" name="max_report_simu_process" id="max_report_simu_process" value="{{ old('max_report_simu_process', '0') }}" step="1">
                            @if($errors->has('max_report_simu_process'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('max_report_simu_process') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.setting.fields.max_report_simu_process_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="max_data_source_simu_process">{{ trans('cruds.setting.fields.max_data_source_simu_process') }}</label>
                            <input class="form-control" type="number" name="max_data_source_simu_process" id="max_data_source_simu_process" value="{{ old('max_data_source_simu_process', '0') }}" step="1">
                            @if($errors->has('max_data_source_simu_process'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('max_data_source_simu_process') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.setting.fields.max_data_source_simu_process_helper') }}</span>
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
    Dropzone.options.orgLogoDropzone = {
    url: '{{ route('frontend.settings.storeMedia') }}',
    maxFilesize: 10, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 10,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="org_logo"]').remove()
      $('form').append('<input type="hidden" name="org_logo" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="org_logo"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($setting) && $setting->org_logo)
      var file = {!! json_encode($setting->org_logo) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="org_logo" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
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
<script>
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('frontend.settings.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $setting->id ?? 0 }}');
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>

@endsection