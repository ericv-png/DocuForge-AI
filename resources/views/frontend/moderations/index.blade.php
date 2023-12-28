@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('moderation_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.moderations.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.moderation.title_singular') }}
                        </a>
                    </div>
                </div>
            @endcan
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.moderation.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Moderation">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.moderation.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.moderation.fields.flagged') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.moderation.fields.response') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.moderation.fields.query_message') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.moderation.fields.data_source') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($moderations as $key => $moderation)
                                    <tr data-entry-id="{{ $moderation->id }}">
                                        <td>
                                            {{ $moderation->id ?? '' }}
                                        </td>
                                        <td>
                                            <span style="display:none">{{ $moderation->flagged ?? '' }}</span>
                                            <input type="checkbox" disabled="disabled" {{ $moderation->flagged ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            {{ $moderation->response ?? '' }}
                                        </td>
                                        <td>
                                            {{ $moderation->query_message->message ?? '' }}
                                        </td>
                                        <td>
                                            {{ $moderation->data_source->name ?? '' }}
                                        </td>
                                        <td>
                                            @can('moderation_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.moderations.show', $moderation->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('moderation_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.moderations.edit', $moderation->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('moderation_delete')
                                                <form action="{{ route('frontend.moderations.destroy', $moderation->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('moderation_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.moderations.massDestroy') }}",
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
  let table = $('.datatable-Moderation:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection