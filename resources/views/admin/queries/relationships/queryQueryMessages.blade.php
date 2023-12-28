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
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-queryQueryMessages">
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
                <tbody>
                    @foreach($queryMessages as $key => $queryMessage)
                        <tr data-entry-id="{{ $queryMessage->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $queryMessage->id ?? '' }}
                            </td>
                            <td>
                                {{ $queryMessage->reference ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\QueryMessage::TYPE_SELECT[$queryMessage->type] ?? '' }}
                            </td>
                            <td>
                                {{ $queryMessage->query->name ?? '' }}
                            </td>
                            <td>
                                {{ $queryMessage->message ?? '' }}
                            </td>
                            <td>
                                {{ $queryMessage->report->name ?? '' }}
                            </td>
                            <td>
                                {{ $queryMessage->tokens ?? '' }}
                            </td>
                            <td>
                                {{ $queryMessage->ai_model ?? '' }}
                            </td>
                            <td>
                                @can('query_message_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.query-messages.show', $queryMessage->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('query_message_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.query-messages.edit', $queryMessage->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('query_message_delete')
                                    <form action="{{ route('admin.query-messages.destroy', $queryMessage->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('query_message_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.query-messages.massDestroy') }}",
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
  let table = $('.datatable-queryQueryMessages:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection