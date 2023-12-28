@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.extractedData.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.extracted-datas.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.extractedData.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $extractedData->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.extractedData.fields.source_file') }}
                                    </th>
                                    <td>
                                        {{ $extractedData->source_file->name ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.extractedData.fields.excerpt') }}
                                    </th>
                                    <td>
                                        {{ $extractedData->excerpt }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.extractedData.fields.summary') }}
                                    </th>
                                    <td>
                                        {{ $extractedData->summary }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.extractedData.fields.extracted_data') }}
                                    </th>
                                    <td>
                                        {{ $extractedData->extracted_data }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.extractedData.fields.tokens') }}
                                    </th>
                                    <td>
                                        {{ $extractedData->tokens }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.extractedData.fields.ai_model') }}
                                    </th>
                                    <td>
                                        {{ $extractedData->ai_model }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.extracted-datas.index') }}">
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