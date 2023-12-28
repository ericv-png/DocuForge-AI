<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDataCategoryRequest;
use App\Http\Requests\StoreDataCategoryRequest;
use App\Http\Requests\UpdateDataCategoryRequest;
use App\Models\DataCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DataCategoryController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('data_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = DataCategory::with(['created_by'])->select(sprintf('%s.*', (new DataCategory)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'data_category_show';
                $editGate      = 'data_category_edit';
                $deleteGate    = 'data_category_delete';
                $crudRoutePart = 'data-categories';

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
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('admin.dataCategories.index');
    }

    public function create()
    {
        abort_if(Gate::denies('data_category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.dataCategories.create');
    }

    public function store(StoreDataCategoryRequest $request)
    {
        $dataCategory = DataCategory::create($request->all());

        return redirect()->route('admin.data-categories.index');
    }

    public function edit(DataCategory $dataCategory)
    {
        abort_if(Gate::denies('data_category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dataCategory->load('created_by');

        return view('admin.dataCategories.edit', compact('dataCategory'));
    }

    public function update(UpdateDataCategoryRequest $request, DataCategory $dataCategory)
    {
        $dataCategory->update($request->all());

        return redirect()->route('admin.data-categories.index');
    }

    public function show(DataCategory $dataCategory)
    {
        abort_if(Gate::denies('data_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dataCategory->load('created_by', 'categoryDataSources');

        return view('admin.dataCategories.show', compact('dataCategory'));
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
