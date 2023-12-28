@extends('layouts.admin')
@section('content')
@can('query_message_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.query-messages.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.queryMessage.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.queryMessage.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-QueryMessage">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.queryMessage.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.queryMessage.fields.reference') }}
                    </th>
                    <th>
                        {{ trans('cruds.queryMessage.fields.type') }}
                    </th>
                    <th>
                        {{ trans('cruds.queryMessage.fields.query') }}
                    </th>
                    <th>
                        {{ trans('cruds.queryMessage.fields.message') }}
                    </th>
                    <th>
                        {{ trans('cruds.queryMessage.fields.report') }}
                    </th>
                    <th>
                        {{ trans('cruds.queryMessage.fields.tokens') }}
                    </th>
                    <th>
                        {{ trans('cruds.queryMessage.fields.ai_model') }}
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
@can('query_message_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.query-messages.massDestroy') }}",
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
    ajax: "{{ route('admin.query-messages.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'reference', name: 'reference' },
{ data: 'type', name: 'type' },
{ data: 'query_name', name: 'query.name' },
{ data: 'message', name: 'message' },
{ data: 'report_name', name: 'report.name' },
{ data: 'tokens', name: 'tokens' },
{ data: 'ai_model', name: 'ai_model' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-QueryMessage').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection