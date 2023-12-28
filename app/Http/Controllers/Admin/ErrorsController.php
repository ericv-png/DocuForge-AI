<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyErrorRequest;
use App\Http\Requests\StoreErrorRequest;
use App\Http\Requests\UpdateErrorRequest;
use App\Models\Error;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ErrorsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('error_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Error::with(['query', 'data_source', 'created_by'])->select(sprintf('%s.*', (new Error)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'error_show';
                $editGate      = 'error_edit';
                $deleteGate    = 'error_delete';
                $crudRoutePart = 'errors';

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
            $table->editColumn('message', function ($row) {
                return $row->message ? $row->message : '';
            });
            $table->editColumn('error_data', function ($row) {
                return $row->error_data ? $row->error_data : '';
            });
            $table->addColumn('query_name', function ($row) {
                return $row->query ? $row->query->name : '';
            });

            $table->addColumn('data_source_name', function ($row) {
                return $row->data_source ? $row->data_source->name : '';
            });

            $table->editColumn('data_source.name', function ($row) {
                return $row->data_source ? (is_string($row->data_source) ? $row->data_source : $row->data_source->name) : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'query', 'data_source']);

            return $table->make(true);
        }

        return view('admin.errors.index');
    }

    public function create()
    {
        abort_if(Gate::denies('error_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.errors.create');
    }

    public function store(StoreErrorRequest $request)
    {
        $error = Error::create($request->all());

        return redirect()->route('admin.errors.index');
    }

    public function edit(Error $error)
    {
        abort_if(Gate::denies('error_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $error->load('query', 'data_source', 'created_by');

        return view('admin.errors.edit', compact('error'));
    }

    public function update(UpdateErrorRequest $request, Error $error)
    {
        $error->update($request->all());

        return redirect()->route('admin.errors.index');
    }

    public function show(Error $error)
    {
        abort_if(Gate::denies('error_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $error->load('query', 'data_source', 'created_by');

        return view('admin.errors.show', compact('error'));
    }

    public function destroy(Error $error)
    {
        abort_if(Gate::denies('error_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $error->delete();

        return back();
    }

    public function massDestroy(MassDestroyErrorRequest $request)
    {
        $errors = Error::find(request('ids'));

        foreach ($errors as $error) {
            $error->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
