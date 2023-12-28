@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.setting.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.settings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.setting.fields.id') }}
                        </th>
                        <td>
                            {{ $setting->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.setting.fields.org_name') }}
                        </th>
                        <td>
                            {{ $setting->org_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.setting.fields.org_logo') }}
                        </th>
                        <td>
                            @if($setting->org_logo)
                                <a href="{{ $setting->org_logo->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $setting->org_logo->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.setting.fields.footer_text') }}
                        </th>
                        <td>
                            {!! $setting->footer_text !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.setting.fields.registration_admin_approve') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $setting->registration_admin_approve ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.setting.fields.ai_service_provider') }}
                        </th>
                        <td>
                            {{ App\Models\Setting::AI_SERVICE_PROVIDER_SELECT[$setting->ai_service_provider] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.setting.fields.ai_service_provider_credentials') }}
                        </th>
                        <td>
                            {{ $setting->ai_service_provider_credentials }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.setting.fields.ai_processing_model') }}
                        </th>
                        <td>
                            {{ $setting->ai_processing_model }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.setting.fields.api_status') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $setting->api_status ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.setting.fields.image_file_processing') }}
                        </th>
                        <td>
                            {{ App\Models\Setting::IMAGE_FILE_PROCESSING_SELECT[$setting->image_file_processing] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.setting.fields.image_file_processing_model') }}
                        </th>
                        <td>
                            {{ $setting->image_file_processing_model }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.setting.fields.image_file_processing_credentials') }}
                        </th>
                        <td>
                            {{ $setting->image_file_processing_credentials }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.setting.fields.text_file_processing') }}
                        </th>
                        <td>
                            {{ App\Models\Setting::TEXT_FILE_PROCESSING_SELECT[$setting->text_file_processing] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.setting.fields.text_file_processing_model') }}
                        </th>
                        <td>
                            {{ $setting->text_file_processing_model }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.setting.fields.text_file_processing_credentials') }}
                        </th>
                        <td>
                            {{ $setting->text_file_processing_credentials }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.setting.fields.mail_credentials') }}
                        </th>
                        <td>
                            {{ $setting->mail_credentials }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.setting.fields.host_url') }}
                        </th>
                        <td>
                            {{ $setting->host_url }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.setting.fields.moderation') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $setting->moderation ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.setting.fields.registration') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $setting->registration ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.setting.fields.max_report_simu_process') }}
                        </th>
                        <td>
                            {{ $setting->max_report_simu_process }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.setting.fields.max_data_source_simu_process') }}
                        </th>
                        <td>
                            {{ $setting->max_data_source_simu_process }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.settings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection