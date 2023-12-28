<?php

namespace App\Http\Controllers\Frontend;

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

class ModerationController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('moderation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $moderations = Moderation::with(['query_message', 'data_source', 'created_by'])->get();

        return view('frontend.moderations.index', compact('moderations'));
    }

    public function create()
    {
        abort_if(Gate::denies('moderation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $query_messages = QueryMessage::pluck('message', 'id')->prepend(trans('global.pleaseSelect'), '');

        $data_sources = DataSource::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.moderations.create', compact('data_sources', 'query_messages'));
    }

    public function store(StoreModerationRequest $request)
    {
        $moderation = Moderation::create($request->all());

        return redirect()->route('frontend.moderations.index');
    }

    public function edit(Moderation $moderation)
    {
        abort_if(Gate::denies('moderation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $query_messages = QueryMessage::pluck('message', 'id')->prepend(trans('global.pleaseSelect'), '');

        $data_sources = DataSource::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $moderation->load('query_message', 'data_source', 'created_by');

        return view('frontend.moderations.edit', compact('data_sources', 'moderation', 'query_messages'));
    }

    public function update(UpdateModerationRequest $request, Moderation $moderation)
    {
        $moderation->update($request->all());

        return redirect()->route('frontend.moderations.index');
    }

    public function show(Moderation $moderation)
    {
        abort_if(Gate::denies('moderation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $moderation->load('query_message', 'data_source', 'created_by');

        return view('frontend.moderations.show', compact('moderation'));
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
