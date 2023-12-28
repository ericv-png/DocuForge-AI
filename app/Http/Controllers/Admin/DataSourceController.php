<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;

class DataSourceController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('data_source_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = DataSource::with(['categories', 'created_by'])->select(sprintf('%s.*', (new DataSource)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'data_source_show';
                $editGate      = 'data_source_edit';
                $deleteGate    = 'data_source_delete';
                $crudRoutePart = 'data-sources';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('reference', function ($row) {
                return $row->reference ? $row->reference : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('category', function ($row) {
                $labels = [];
                foreach ($row->categories as $category) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $category->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('type', function ($row) {
                return $row->type ? DataSource::TYPE_SELECT[$row->type] : '';
            });
            $table->editColumn('url', function ($row) {
                return $row->url ? $row->url : '';
            });
            $table->editColumn('file', function ($row) {
                return $row->file ? '<a href="' . $row->file->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>' : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? DataSource::STATUS_SELECT[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'category', 'file']);

            return $table->make(true);
        }

        return view('admin.dataSources.index');
    }

    public function create()
    {
        abort_if(Gate::denies('data_source_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = DataCategory::pluck('name', 'id');

        return view('admin.dataSources.create', compact('categories'));
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

        return redirect()->route('admin.data-sources.index');
    }

    public function edit(DataSource $dataSource)
    {
        abort_if(Gate::denies('data_source_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = DataCategory::pluck('name', 'id');

        $dataSource->load('categories', 'created_by');

        return view('admin.dataSources.edit', compact('categories', 'dataSource'));
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

        return redirect()->route('admin.data-sources.index');
    }

    public function show(DataSource $dataSource)
    {
        abort_if(Gate::denies('data_source_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dataSource->load('categories', 'created_by', 'dataSourceQueries');

        return view('admin.dataSources.show', compact('dataSource'));
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
