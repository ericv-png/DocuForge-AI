@extends('layouts.admin')
@section('content')
@can('extracted_data_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.extracted-datas.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.extractedData.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.extractedData.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-ExtractedData">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.extractedData.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.extractedData.fields.source_file') }}
                    </th>
                    <th>
                        {{ trans('cruds.extractedData.fields.excerpt') }}
                    </th>
                    <th>
                        {{ trans('cruds.extractedData.fields.summary') }}
                    </th>
                    <th>
                        {{ trans('cruds.extractedData.fields.extracted_data') }}
                    </th>
                    <th>
                        {{ trans('cruds.extractedData.fields.tokens') }}
                    </th>
                    <th>
                        {{ trans('cruds.extractedData.fields.ai_model') }}
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
@can('extracted_data_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.extracted-datas.massDestroy') }}",
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
    ajax: "{{ route('admin.extracted-datas.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'source_file_name', name: 'source_file.name' },
{ data: 'excerpt', name: 'excerpt' },
{ data: 'summary', name: 'summary' },
{ data: 'extracted_data', name: 'extracted_data' },
{ data: 'tokens', name: 'tokens' },
{ data: 'ai_model', name: 'ai_model' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-ExtractedData').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection