@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('error_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.errors.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.error.title_singular') }}
                        </a>
                    </div>
                </div>
            @endcan
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.error.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Error">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.error.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.error.fields.name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.error.fields.message') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.error.fields.error_data') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.error.fields.query') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.error.fields.data_source') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.dataSource.fields.name') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($errors as $key => $error)
                                    <tr data-entry-id="{{ $error->id }}">
                                        <td>
                                            {{ $error->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $error->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $error->message ?? '' }}
                                        </td>
                                        <td>
                                            {{ $error->error_data ?? '' }}
                                        </td>
                                        <td>
                                            {{ $error->query->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $error->data_source->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $error->data_source->name ?? '' }}
                                        </td>
                                        <td>
                                            @can('error_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.errors.show', $error->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('error_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.errors.edit', $error->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('error_delete')
                                                <form action="{{ route('frontend.errors.destroy', $error->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('error_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.errors.massDestroy') }}",
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
  let table = $('.datatable-Error:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection