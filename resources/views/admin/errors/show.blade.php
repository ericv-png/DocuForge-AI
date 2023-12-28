@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.error.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.errors.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.error.fields.id') }}
                        </th>
                        <td>
                            {{ $error->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.error.fields.name') }}
                        </th>
                        <td>
                            {{ $error->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.error.fields.message') }}
                        </th>
                        <td>
                            {{ $error->message }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.error.fields.error_data') }}
                        </th>
                        <td>
                            {{ $error->error_data }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.error.fields.query') }}
                        </th>
                        <td>
                            {{ $error->query->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.error.fields.data_source') }}
                        </th>
                        <td>
                            {{ $error->data_source->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.errors.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection