<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyModerationRequest;
use App\Http\Requests\StoreModerationRequest;
use App\Http\Requests\UpdateModerationRequest;
use App\Models\DataSource;
use App\Models\Moderation;
use App\Models\QueryMessage;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ModerationController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('moderation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Moderation::with(['query_message', 'data_source', 'created_by'])->select(sprintf('%s.*', (new Moderation)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'moderation_show';
                $editGate      = 'moderation_edit';
                $deleteGate    = 'moderation_delete';
                $crudRoutePart = 'moderations';

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
            $table->editColumn('flagged', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->flagged ? 'checked' : null) . '>';
            });
            $table->editColumn('response', function ($row) {
                return $row->response ? $row->response : '';
            });
            $table->addColumn('query_message_message', function ($row) {
                return $row->query_message ? $row->query_message->message : '';
            });

            $table->addColumn('data_source_name', function ($row) {
                return $row->data_source ? $row->data_source->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'flagged', 'query_message', 'data_source']);

            return $table->make(true);
        }

        return view('admin.moderations.index');
    }

    public function create()
    {
        abort_if(Gate::denies('moderation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $query_messages = QueryMessage::pluck('message', 'id')->prepend(trans('global.pleaseSelect'), '');

        $data_sources = DataSource::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.moderations.create', compact('data_sources', 'query_messages'));
    }

    public function store(StoreModerationRequest $request)
    {
        $moderation = Moderation::create($request->all());

        return redirect()->route('admin.moderations.index');
    }

    public function edit(Moderation $moderation)
    {
        abort_if(Gate::denies('moderation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $query_messages = QueryMessage::pluck('message', 'id')->prepend(trans('global.pleaseSelect'), '');

        $data_sources = DataSource::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $moderation->load('query_message', 'data_source', 'created_by');

        return view('admin.moderations.edit', compact('data_sources', 'moderation', 'query_messages'));
    }

    public function update(UpdateModerationRequest $request, Moderation $moderation)
    {
        $moderation->update($request->all());

        return redirect()->route('admin.moderations.index');
    }

    public function show(Moderation $moderation)
    {
        abort_if(Gate::denies('moderation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $moderation->load('query_message', 'data_source', 'created_by');

        return view('admin.moderations.show', compact('moderation'));
    }

    public function destroy(Moderation $moderation)
    {
        abort_if(Gate::denies('moderation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $moderation->delete();

        return back();
    }

    public function massDestroy(MassDestroyModerationRequest $request)
    {
        $moderations = Moderation::find(request('ids'));

        foreach ($moderations as $moderation) {
            $moderation->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
