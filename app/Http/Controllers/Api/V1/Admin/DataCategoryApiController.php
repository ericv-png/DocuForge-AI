<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDataCategoryRequest;
use App\Http\Requests\UpdateDataCategoryRequest;
use App\Http\Resources\Admin\DataCategoryResource;
use App\Models\DataCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DataCategoryApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('data_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DataCategoryResource(DataCategory::with(['created_by'])->get());
    }

    public function store(StoreDataCategoryRequest $request)
    {
        $dataCategory = DataCategory::create($request->all());

        return (new DataCategoryResource($dataCategory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(DataCategory $dataCategory)
    {
        abort_if(Gate::denies('data_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DataCategoryResource($dataCategory->load(['created_by']));
    }

    public function update(UpdateDataCategoryRequest $request, DataCategory $dataCategory)
    {
        $dataCategory->update($request->all());

        return (new DataCategoryResource($dataCategory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(DataCategory $dataCategory)
    {
        abort_if(Gate::denies('data_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dataCategory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
