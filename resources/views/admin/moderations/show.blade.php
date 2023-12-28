@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.moderation.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.moderations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.moderation.fields.id') }}
                        </th>
                        <td>
                            {{ $moderation->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moderation.fields.flagged') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $moderation->flagged ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moderation.fields.response') }}
                        </th>
                        <td>
                            {{ $moderation->response }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moderation.fields.query_message') }}
                        </th>
                        <td>
                            {{ $moderation->query_message->message ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.moderation.fields.data_source') }}
                        </th>
                        <td>
                            {{ $moderation->data_source->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.moderations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection