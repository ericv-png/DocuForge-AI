<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyExtractedDataRequest;
use App\Http\Requests\StoreExtractedDataRequest;
use App\Http\Requests\UpdateExtractedDataRequest;
use App\Models\DataSource;
use App\Models\ExtractedData;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ExtractedDataController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('extracted_data_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ExtractedData::with(['source_file', 'created_by'])->select(sprintf('%s.*', (new ExtractedData)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'extracted_data_show';
                $editGate      = 'extracted_data_edit';
                $deleteGate    = 'extracted_data_delete';
                $crudRoutePart = 'extracted-datas';

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
            $table->addColumn('source_file_name', function ($row) {
                return $row->source_file ? $row->source_file->name : '';
            });

            $table->editColumn('excerpt', function ($row) {
                return $row->excerpt ? $row->excerpt : '';
            });
            $table->editColumn('summary', function ($row) {
                return $row->summary ? $row->summary : '';
            });
            $table->editColumn('extracted_data', function ($row) {
                return $row->extracted_data ? $row->extracted_data : '';
            });
            $table->editColumn('tokens', function ($row) {
                return $row->tokens ? $row->tokens : '';
            });
            $table->editColumn('ai_model', function ($row) {
                return $row->ai_model ? $row->ai_model : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'source_file']);

            return $table->make(true);
        }

        return view('admin.extractedDatas.index');
    }

    public function create()
    {
        abort_if(Gate::denies('extracted_data_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $source_files = DataSource::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.extractedDatas.create', compact('source_files'));
    }

    public function store(StoreExtractedDataRequest $request)
    {
        $extractedData = ExtractedData::create($request->all());

        return redirect()->route('admin.extracted-datas.index');
    }

    public function edit(ExtractedData $extractedData)
    {
        abort_if(Gate::denies('extracted_data_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $source_files = DataSource::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $extractedData->load('source_file', 'created_by');

        return view('admin.extractedDatas.edit', compact('extractedData', 'source_files'));
    }

    public function update(UpdateExtractedDataRequest $request, ExtractedData $extractedData)
    {
        $extractedData->update($request->all());

        return redirect()->route('admin.extracted-datas.index');
    }

    public function show(ExtractedData $extractedData)
    {
        abort_if(Gate::denies('extracted_data_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $extractedData->load('source_file', 'created_by');

        return view('admin.extractedDatas.show', compact('extractedData'));
    }

    public function destroy(ExtractedData $extractedData)
    {
        abort_if(Gate::denies('extracted_data_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $extractedData->delete();

        return back();
    }

    public function massDestroy(MassDestroyExtractedDataRequest $request)
    {
        $extractedDatas = ExtractedData::find(request('ids'));

        foreach ($extractedDatas as $extractedData) {
            $extractedData->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
