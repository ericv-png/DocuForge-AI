@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('setting_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.settings.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.setting.title_singular') }}
                        </a>
                    </div>
                </div>
            @endcan
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.setting.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Setting">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.setting.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.setting.fields.org_name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.setting.fields.org_logo') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.setting.fields.registration_admin_approve') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.setting.fields.ai_service_provider') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.setting.fields.ai_service_provider_credentials') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.setting.fields.ai_processing_model') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.setting.fields.api_status') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.setting.fields.image_file_processing') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.setting.fields.image_file_processing_model') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.setting.fields.image_file_processing_credentials') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.setting.fields.text_file_processing') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.setting.fields.text_file_processing_model') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.setting.fields.text_file_processing_credentials') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.setting.fields.mail_credentials') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.setting.fields.host_url') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.setting.fields.moderation') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.setting.fields.registration') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.setting.fields.max_report_simu_process') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.setting.fields.max_data_source_simu_process') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($settings as $key => $setting)
                                    <tr data-entry-id="{{ $setting->id }}">
                                        <td>
                                            {{ $setting->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $setting->org_name ?? '' }}
                                        </td>
                                        <td>
                                            @if($setting->org_logo)
                                                <a href="{{ $setting->org_logo->getUrl() }}" target="_blank" style="display: inline-block">
                                                    <img src="{{ $setting->org_logo->getUrl('thumb') }}">
                                                </a>
                                            @endif
                                        </td>
                                        <td>
                                            <span style="display:none">{{ $setting->registration_admin_approve ?? '' }}</span>
                                            <input type="checkbox" disabled="disabled" {{ $setting->registration_admin_approve ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            {{ App\Models\Setting::AI_SERVICE_PROVIDER_SELECT[$setting->ai_service_provider] ?? '' }}
                                        </td>
                                        <td>
                                            {{ $setting->ai_service_provider_credentials ?? '' }}
                                        </td>
                                        <td>
                                            {{ $setting->ai_processing_model ?? '' }}
                                        </td>
                                        <td>
                                            <span style="display:none">{{ $setting->api_status ?? '' }}</span>
                                            <input type="checkbox" disabled="disabled" {{ $setting->api_status ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            {{ App\Models\Setting::IMAGE_FILE_PROCESSING_SELECT[$setting->image_file_processing] ?? '' }}
                                        </td>
                                        <td>
                                            {{ $setting->image_file_processing_model ?? '' }}
                                        </td>
                                        <td>
                                            {{ $setting->image_file_processing_credentials ?? '' }}
                                        </td>
                                        <td>
                                            {{ App\Models\Setting::TEXT_FILE_PROCESSING_SELECT[$setting->text_file_processing] ?? '' }}
                                        </td>
                                        <td>
                                            {{ $setting->text_file_processing_model ?? '' }}
                                        </td>
                                        <td>
                                            {{ $setting->text_file_processing_credentials ?? '' }}
                                        </td>
                                        <td>
                                            {{ $setting->mail_credentials ?? '' }}
                                        </td>
                                        <td>
                                            {{ $setting->host_url ?? '' }}
                                        </td>
                                        <td>
                                            <span style="display:none">{{ $setting->moderation ?? '' }}</span>
                                            <input type="checkbox" disabled="disabled" {{ $setting->moderation ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            <span style="display:none">{{ $setting->registration ?? '' }}</span>
                                            <input type="checkbox" disabled="disabled" {{ $setting->registration ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            {{ $setting->max_report_simu_process ?? '' }}
                                        </td>
                                        <td>
                                            {{ $setting->max_data_source_simu_process ?? '' }}
                                        </td>
                                        <td>
                                            @can('setting_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.settings.show', $setting->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('setting_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.settings.edit', $setting->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('setting_delete')
                                                <form action="{{ route('frontend.settings.destroy', $setting->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                </form>
                                            @endcan

                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('setting_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.settings.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Setting:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection