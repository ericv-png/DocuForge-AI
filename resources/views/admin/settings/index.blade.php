@extends('layouts.admin')
@section('content')
@can('setting_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.settings.create') }}">
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
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Setting">
            <thead>
                <tr>
                    <th width="10">

                    </th>
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
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('setting_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.settings.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
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

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.settings.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'org_name', name: 'org_name' },
{ data: 'org_logo', name: 'org_logo', sortable: false, searchable: false },
{ data: 'registration_admin_approve', name: 'registration_admin_approve' },
{ data: 'ai_service_provider', name: 'ai_service_provider' },
{ data: 'ai_service_provider_credentials', name: 'ai_service_provider_credentials' },
{ data: 'ai_processing_model', name: 'ai_processing_model' },
{ data: 'api_status', name: 'api_status' },
{ data: 'image_file_processing', name: 'image_file_processing' },
{ data: 'image_file_processing_model', name: 'image_file_processing_model' },
{ data: 'image_file_processing_credentials', name: 'image_file_processing_credentials' },
{ data: 'text_file_processing', name: 'text_file_processing' },
{ data: 'text_file_processing_model', name: 'text_file_processing_model' },
{ data: 'text_file_processing_credentials', name: 'text_file_processing_credentials' },
{ data: 'mail_credentials', name: 'mail_credentials' },
{ data: 'host_url', name: 'host_url' },
{ data: 'moderation', name: 'moderation' },
{ data: 'registration', name: 'registration' },
{ data: 'max_report_simu_process', name: 'max_report_simu_process' },
{ data: 'max_data_source_simu_process', name: 'max_data_source_simu_process' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Setting').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection