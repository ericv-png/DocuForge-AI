@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.dataSource.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.data-sources.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.dataSource.fields.id') }}
                        </th>
                        <td>
                            {{ $dataSource->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dataSource.fields.reference') }}
                        </th>
                        <td>
                            {{ $dataSource->reference }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dataSource.fields.name') }}
                        </th>
                        <td>
                            {{ $dataSource->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dataSource.fields.category') }}
                        </th>
                        <td>
                            @foreach($dataSource->categories as $key => $category)
                                <span class="label label-info">{{ $category->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dataSource.fields.type') }}
                        </th>
                        <td>
                            {{ App\Models\DataSource::TYPE_SELECT[$dataSource->type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dataSource.fields.url') }}
                        </th>
                        <td>
                            {{ $dataSource->url }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dataSource.fields.file') }}
                        </th>
                        <td>
                            @if($dataSource->file)
                                <a href="{{ $dataSource->file->getUrl() }}" target="_blank">
                                    {{ trans('global.view_file') }}
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dataSource.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\DataSource::STATUS_SELECT[$dataSource->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.data-sources.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#data_source_queries" role="tab" data-toggle="tab">
                {{ trans('cruds.query.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="data_source_queries">
            @includeIf('admin.dataSources.relationships.dataSourceQueries', ['queries' => $dataSource->dataSourceQueries])
        </div>
    </div>
</div>

@endsection