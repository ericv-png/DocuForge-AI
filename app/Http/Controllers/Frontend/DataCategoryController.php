<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDataCategoryRequest;
use App\Http\Requests\StoreDataCategoryRequest;
use App\Http\Requests\UpdateDataCategoryRequest;
use App\Models\DataCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DataCategoryController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('data_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dataCategories = DataCategory::with(['created_by'])->get();

        return view('frontend.dataCategories.index', compact('dataCategories'));
    }

    public function create()
    {
        abort_if(Gate::denies('data_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.dataCategories.create');
    }

    public function store(StoreDataCategoryRequest $request)
    {
        $dataCategory = DataCategory::create($request->all());

        return redirect()->route('frontend.data-categories.index');
    }

    public function edit(DataCategory $dataCategory)
    {
        abort_if(Gate::denies('data_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dataCategory->load('created_by');

        return view('frontend.dataCategories.edit', compact('dataCategory'));
    }

    public function update(UpdateDataCategoryRequest $request, DataCategory $dataCategory)
    {
        $dataCategory->update($request->all());

        return redirect()->route('frontend.data-categories.index');
    }

    public function show(DataCategory $dataCategory)
    {
        abort_if(Gate::denies('data_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dataCategory->load('created_by');

        return view('frontend.dataCategories.show', compact('dataCategory'));
    }

    public function destroy(DataCategory $dataCategory)
    {
        abort_if(Gate::denies('data_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dataCategory->delete();

        return back();
    }

    public function massDestroy(MassDestroyDataCategoryRequest $request)
    {
        $dataCategories = DataCategory::find(request('ids'));

        foreach ($dataCategories as $dataCategory) {
            $dataCategory->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
