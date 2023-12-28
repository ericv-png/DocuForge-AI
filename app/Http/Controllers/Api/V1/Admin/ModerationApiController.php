<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreModerationRequest;
use App\Http\Requests\UpdateModerationRequest;
use App\Http\Resources\Admin\ModerationResource;
use App\Models\Moderation;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ModerationApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('moderation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ModerationResource(Moderation::with(['query_message', 'data_source', 'created_by'])->get());
    }

    public function store(StoreModerationRequest $request)
    {
        $moderation = Moderation::create($request->all());

        return (new ModerationResource($moderation))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Moderation $moderation)
    {
        abort_if(Gate::denies('moderation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ModerationResource($moderation->load(['query_message', 'data_source', 'created_by']));
    }

    public function update(UpdateModerationRequest $request, Moderation $moderation)
    {
        $moderation->update($request->all());

        return (new ModerationResource($moderation))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Moderation $moderation)
    {
        abort_if(Gate::denies('moderation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $moderation->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
