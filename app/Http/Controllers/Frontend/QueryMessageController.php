<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyQueryMessageRequest;
use App\Http\Requests\StoreQueryMessageRequest;
use App\Http\Requests\UpdateQueryMessageRequest;
use App\Models\Query;
use App\Models\QueryMessage;
use App\Models\Report;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QueryMessageController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('query_message_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $queryMessages = QueryMessage::with(['query', 'report', 'created_by'])->get();

        return view('frontend.queryMessages.index', compact('queryMessages'));
    }

    public function create()
    {
        abort_if(Gate::denies('query_message_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $queries = Query::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $reports = Report::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.queryMessages.create', compact('queries', 'reports'));
    }

    public function store(StoreQueryMessageRequest $request)
    {
        $queryMessage = QueryMessage::create($request->all());

        return redirect()->route('frontend.query-messages.index');
    }

    public function edit(QueryMessage $queryMessage)
    {
        abort_if(Gate::denies('query_message_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $queries = Query::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $reports = Report::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $queryMessage->load('query', 'report', 'created_by');

        return view('frontend.queryMessages.edit', compact('queries', 'queryMessage', 'reports'));
    }

    public function update(UpdateQueryMessageRequest $request, QueryMessage $queryMessage)
    {
        $queryMessage->update($request->all());

        return redirect()->route('frontend.query-messages.index');
    }

    public function show(QueryMessage $queryMessage)
    {
        abort_if(Gate::denies('query_message_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $queryMessage->load('query', 'report', 'created_by');

        return view('frontend.queryMessages.show', compact('queryMessage'));
    }

    public function destroy(QueryMessage $queryMessage)
    {
        abort_if(Gate::denies('query_message_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $queryMessage->delete();

        return back();
    }

    public function massDestroy(MassDestroyQueryMessageRequest $request)
    {
        $queryMessages = QueryMessage::find(request('ids'));

        foreach ($queryMessages as $queryMessage) {
            $queryMessage->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
