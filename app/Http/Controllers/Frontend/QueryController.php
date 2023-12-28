<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyQueryRequest;
use App\Http\Requests\StoreQueryRequest;
use App\Http\Requests\UpdateQueryRequest;
use App\Models\DataSource;
use App\Models\Query;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QueryController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('query_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $queries = Query::with(['data_sources', 'created_by'])->get();

        return view('frontend.queries.index', compact('queries'));
    }

    public function create()
    {
        abort_if(Gate::denies('query_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data_sources = DataSource::pluck('name', 'id');

        return view('frontend.queries.create', compact('data_sources'));
    }

    public function store(StoreQueryRequest $request)
    {
        $query = Query::create($request->all());
        $query->data_sources()->sync($request->input('data_sources', []));

        return redirect()->route('frontend.queries.index');
    }

    public function edit(Query $query)
    {
        abort_if(Gate::denies('query_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data_sources = DataSource::pluck('name', 'id');

        $query->load('data_sources', 'created_by');

        return view('frontend.queries.edit', compact('data_sources', 'query'));
    }

    public function update(UpdateQueryRequest $request, Query $query)
    {
        $query->update($request->all());
        $query->data_sources()->sync($request->input('data_sources', []));

        return redirect()->route('frontend.queries.index');
    }

    public function show(Query $query)
    {
        abort_if(Gate::denies('query_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $query->load('data_sources', 'created_by', 'queryQueryMessages');

        return view('frontend.queries.show', compact('query'));
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
