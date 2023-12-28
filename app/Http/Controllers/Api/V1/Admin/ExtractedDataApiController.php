<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExtractedDataRequest;
use App\Http\Requests\UpdateExtractedDataRequest;
use App\Http\Resources\Admin\ExtractedDataResource;
use App\Models\ExtractedData;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExtractedDataApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('extracted_data_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ExtractedDataResource(ExtractedData::with(['source_file', 'created_by'])->get());
    }

    public function store(StoreExtractedDataRequest $request)
    {
        $extractedData = ExtractedData::create($request->all());

        return (new ExtractedDataResource($extractedData))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ExtractedData $extractedData)
    {
        abort_if(Gate::denies('extracted_data_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ExtractedDataResource($extractedData->load(['source_file', 'created_by']));
    }

    public function update(UpdateExtractedDataRequest $request, ExtractedData $extractedData)
    {
        $extractedData->update($request->all());

        return (new ExtractedDataResource($extractedData))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ExtractedData $extractedData)
    {
        abort_if(Gate::denies('extracted_data_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $extractedData->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
