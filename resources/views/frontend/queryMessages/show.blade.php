@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.queryMessage.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.query-messages.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.queryMessage.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $queryMessage->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.queryMessage.fields.reference') }}
                                    </th>
                                    <td>
                                        {{ $queryMessage->reference }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.queryMessage.fields.type') }}
                                    </th>
                                    <td>
                                        {{ App\Models\QueryMessage::TYPE_SELECT[$queryMessage->type] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.queryMessage.fields.query') }}
                                    </th>
                                    <td>
                                        {{ $queryMessage->query->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.queryMessage.fields.message') }}
                                    </th>
                                    <td>
                                        {{ $queryMessage->message }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.queryMessage.fields.report') }}
                                    </th>
                                    <td>
                                        {{ $queryMessage->report->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.queryMessage.fields.tokens') }}
                                    </th>
                                    <td>
                                        {{ $queryMessage->tokens }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.queryMessage.fields.ai_model') }}
                                    </th>
                                    <td>
                                        {{ $queryMessage->ai_model }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.query-messages.index') }}">
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