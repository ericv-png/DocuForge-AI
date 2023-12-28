@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.query.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.queries.index') }}">
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
                            <a class="btn btn-default" href="{{ route('frontend.queries.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection