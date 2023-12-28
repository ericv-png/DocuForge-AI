<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyExtractedDataRequest;
use App\Http\Requests\StoreExtractedDataRequest;
use App\Http\Requests\UpdateExtractedDataRequest;
use App\Models\DataSource;
use App\Models\ExtractedData;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExtractedDataController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('extracted_data_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $extractedDatas = ExtractedData::with(['source_file', 'created_by'])->get();

        return view('frontend.extractedDatas.index', compact('extractedDatas'));
    }

    public function create()
    {
        abort_if(Gate::denies('extracted_data_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $source_files = DataSource::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.extractedDatas.create', compact('source_files'));
    }

    public function store(StoreExtractedDataRequest $request)
    {
        $extractedData = ExtractedData::create($request->all());

        return redirect()->route('frontend.extracted-datas.index');
    }

    public function edit(ExtractedData $extractedData)
    {
        abort_if(Gate::denies('extracted_data_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $source_files = DataSource::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $extractedData->load('source_file', 'created_by');

        return view('frontend.extractedDatas.edit', compact('extractedData', 'source_files'));
    }

    public function update(UpdateExtractedDataRequest $request, ExtractedData $extractedData)
    {
        $extractedData->update($request->all());

        return redirect()->route('frontend.extracted-datas.index');
    }

    public function show(ExtractedData $extractedData)
    {
        abort_if(Gate::denies('extracted_data_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $extractedData->load('source_file', 'created_by');

        return view('frontend.extractedDatas.show', compact('extractedData'));
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
