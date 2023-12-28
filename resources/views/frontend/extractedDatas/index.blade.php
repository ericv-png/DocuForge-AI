@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('extracted_data_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.extracted-datas.create') }}">
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
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-ExtractedData">
                            <thead>
                                <tr>
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
                            <tbody>
                                @foreach($extractedDatas as $key => $extractedData)
                                    <tr data-entry-id="{{ $extractedData->id }}">
                                        <td>
                                            {{ $extractedData->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $extractedData->source_file->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $extractedData->excerpt ?? '' }}
                                        </td>
                                        <td>
                                            {{ $extractedData->summary ?? '' }}
                                        </td>
                                        <td>
                                            {{ $extractedData->extracted_data ?? '' }}
                                        </td>
                                        <td>
                                            {{ $extractedData->tokens ?? '' }}
                                        </td>
                                        <td>
                                            {{ $extractedData->ai_model ?? '' }}
                                        </td>
                                        <td>
                                            @can('extracted_data_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.extracted-datas.show', $extractedData->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('extracted_data_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.extracted-datas.edit', $extractedData->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('extracted_data_delete')
                                                <form action="{{ route('frontend.extracted-datas.destroy', $extractedData->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('extracted_data_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.extracted-datas.massDestroy') }}",
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
  let table = $('.datatable-ExtractedData:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection