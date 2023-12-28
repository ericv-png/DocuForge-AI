@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.dataSource.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.data-sources.index') }}">
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
                            <a class="btn btn-default" href="{{ route('frontend.data-sources.index') }}">
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