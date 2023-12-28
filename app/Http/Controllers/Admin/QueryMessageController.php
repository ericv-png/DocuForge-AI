<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;

class QueryMessageController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('query_message_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = QueryMessage::with(['query', 'report', 'created_by'])->select(sprintf('%s.*', (new QueryMessage)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'query_message_show';
                $editGate      = 'query_message_edit';
                $deleteGate    = 'query_message_delete';
                $crudRoutePart = 'query-messages';

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
            $table->editColumn('type', function ($row) {
                return $row->type ? QueryMessage::TYPE_SELECT[$row->type] : '';
            });
            $table->addColumn('query_name', function ($row) {
                return $row->query ? $row->query->name : '';
            });

            $table->editColumn('message', function ($row) {
                return $row->message ? $row->message : '';
            });
            $table->addColumn('report_name', function ($row) {
                return $row->report ? $row->report->name : '';
            });

            $table->editColumn('tokens', function ($row) {
                return $row->tokens ? $row->tokens : '';
            });
            $table->editColumn('ai_model', function ($row) {
                return $row->ai_model ? $row->ai_model : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'query', 'report']);

            return $table->make(true);
        }

        return view('admin.queryMessages.index');
    }

    public function create()
    {
        abort_if(Gate::denies('query_message_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $queries = Query::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $reports = Report::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.queryMessages.create', compact('queries', 'reports'));
    }

    public function store(StoreQueryMessageRequest $request)
    {
        $queryMessage = QueryMessage::create($request->all());

        return redirect()->route('admin.query-messages.index');
    }

    public function edit(QueryMessage $queryMessage)
    {
        abort_if(Gate::denies('query_message_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $queries = Query::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $reports = Report::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $queryMessage->load('query', 'report', 'created_by');

        return view('admin.queryMessages.edit', compact('queries', 'queryMessage', 'reports'));
    }

    public function update(UpdateQueryMessageRequest $request, QueryMessage $queryMessage)
    {
        $queryMessage->update($request->all());

        return redirect()->route('admin.query-messages.index');
    }

    public function show(QueryMessage $queryMessage)
    {
        abort_if(Gate::denies('query_message_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $queryMessage->load('query', 'report', 'created_by');

        return view('admin.queryMessages.show', compact('queryMessage'));
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
