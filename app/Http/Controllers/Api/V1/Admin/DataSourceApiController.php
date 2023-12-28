<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreDataSourceRequest;
use App\Http\Requests\UpdateDataSourceRequest;
use App\Http\Resources\Admin\DataSourceResource;
use App\Models\DataSource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DataSourceApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('data_source_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DataSourceResource(DataSource::with(['categories', 'created_by'])->get());
    }

    public function store(StoreDataSourceRequest $request)
    {
        $dataSource = DataSource::create($request->all());
        $dataSource->categories()->sync($request->input('categories', []));
        if ($request->input('file', false)) {
            $dataSource->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
        }

        return (new DataSourceResource($dataSource))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(DataSource $dataSource)
    {
        abort_if(Gate::denies('data_source_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DataSourceResource($dataSource->load(['categories', 'created_by']));
    }

    public function update(UpdateDataSourceRequest $request, DataSource $dataSource)
    {
        $dataSource->update($request->all());
        $dataSource->categories()->sync($request->input('categories', []));
        if ($request->input('file', false)) {
            if (! $dataSource->file || $request->input('file') !== $dataSource->file->file_name) {
                if ($dataSource->file) {
                    $dataSource->file->delete();
                }
                $dataSource->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
            }
        } elseif ($dataSource->file) {
            $dataSource->file->delete();
        }

        return (new DataSourceResource($dataSource))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(DataSource $dataSource)
    {
        abort_if(Gate::denies('data_source_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dataSource->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
