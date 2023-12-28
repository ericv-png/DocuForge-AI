@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.query.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.queries.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.query.fields.id') }}
                        </th>
                        <td>
                            {{ $query->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.query.fields.reference') }}
                        </th>
                        <td>
                            {{ $query->reference }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.query.fields.name') }}
                        </th>
                        <td>
                            {{ $query->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.query.fields.data_source') }}
                        </th>
                        <td>
                            @foreach($query->data_sources as $key => $data_source)
                                <span class="label label-info">{{ $data_source->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.query.fields.encrypted') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $query->encrypted ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.queries.index') }}">
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
            <a class="nav-link" href="#query_query_messages" role="tab" data-toggle="tab">
                {{ trans('cruds.queryMessage.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="query_query_messages">
            @includeIf('admin.queries.relationships.queryQueryMessages', ['queryMessages' => $query->queryQueryMessages])
        </div>
    </div>
</div>

@endsection