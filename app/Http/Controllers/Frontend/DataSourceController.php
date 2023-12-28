<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyDataSourceRequest;
use App\Http\Requests\StoreDataSourceRequest;
use App\Http\Requests\UpdateDataSourceRequest;
use App\Models\DataCategory;
use App\Models\DataSource;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class DataSourceController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('data_source_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dataSources = DataSource::with(['categories', 'created_by', 'media'])->get();

        return view('frontend.dataSources.index', compact('dataSources'));
    }

    public function create()
    {
        abort_if(Gate::denies('data_source_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = DataCategory::pluck('name', 'id');

        return view('frontend.dataSources.create', compact('categories'));
    }

    public function store(StoreDataSourceRequest $request)
    {
        $dataSource = DataSource::create($request->all());
        $dataSource->categories()->sync($request->input('categories', []));
        if ($request->input('file', false)) {
            $dataSource->addMedia(storage_path('tmp/uploads/' . basename($request->input('file'))))->toMediaCollection('file');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $dataSource->id]);
        }

        return redirect()->route('frontend.data-sources.index');
    }

    public function edit(DataSource $dataSource)
    {
        abort_if(Gate::denies('data_source_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = DataCategory::pluck('name', 'id');

        $dataSource->load('categories', 'created_by');

        return view('frontend.dataSources.edit', compact('categories', 'dataSource'));
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

        return redirect()->route('frontend.data-sources.index');
    }

    public function show(DataSource $dataSource)
    {
        abort_if(Gate::denies('data_source_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dataSource->load('categories', 'created_by', 'dataSourceQueries');

        return view('frontend.dataSources.show', compact('dataSource'));
    }

    public function destroy(DataSource $dataSource)
    {
        abort_if(Gate::denies('data_source_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dataSource->delete();

        return back();
    }

    public function massDestroy(MassDestroyDataSourceRequest $request)
    {
        $dataSources = DataSource::find(request('ids'));

        foreach ($dataSources as $dataSource) {
            $dataSource->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('data_source_create') && Gate::denies('data_source_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new DataSource();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
