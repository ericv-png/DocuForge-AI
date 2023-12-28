<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyQueryRequest;
use App\Http\Requests\StoreQueryRequest;
use App\Http\Requests\UpdateQueryRequest;
use App\Models\DataSource;
use App\Models\Query;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class QueryController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('query_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Query::with(['data_sources', 'created_by'])->select(sprintf('%s.*', (new Query)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'query_show';
                $editGate      = 'query_edit';
                $deleteGate    = 'query_delete';
                $crudRoutePart = 'queries';

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
            $table->editColumn('data_source', function ($row) {
                $labels = [];
                foreach ($row->data_sources as $data_source) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $data_source->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('encrypted', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->encrypted ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'data_source', 'encrypted']);

            return $table->make(true);
        }

        return view('admin.queries.index');
    }

    public function create()
    {
        abort_if(Gate::denies('query_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data_sources = DataSource::pluck('name', 'id');

        return view('admin.queries.create', compact('data_sources'));
    }

    public function store(StoreQueryRequest $request)
    {
        $query = Query::create($request->all());
        $query->data_sources()->sync($request->input('data_sources', []));

        return redirect()->route('admin.queries.index');
    }

    public function edit(Query $query)
    {
        abort_if(Gate::denies('query_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data_sources = DataSource::pluck('name', 'id');

        $query->load('data_sources', 'created_by');

        return view('admin.queries.edit', compact('data_sources', 'query'));
    }

    public function update(UpdateQueryRequest $request, Query $query)
    {
        $query->update($request->all());
        $query->data_sources()->sync($request->input('data_sources', []));

        return redirect()->route('admin.queries.index');
    }

    public function show(Query $query)
    {
        abort_if(Gate::denies('query_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $query->load('data_sources', 'created_by', 'queryQueryMessages');

        return view('admin.queries.show', compact('query'));
    }

    public function destroy(Query $query)
    {
        abort_if(Gate::denies('query_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $query->delete();

        return back();
    }

    public function massDestroy(MassDestroyQueryRequest $request)
    {
        $queries = Query::find(request('ids'));

        foreach ($queries as $query) {
            $query->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
