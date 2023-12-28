<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQueryMessageRequest;
use App\Http\Requests\UpdateQueryMessageRequest;
use App\Http\Resources\Admin\QueryMessageResource;
use App\Models\QueryMessage;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QueryMessageApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('query_message_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new QueryMessageResource(QueryMessage::with(['query', 'report', 'created_by'])->get());
    }

    public function store(StoreQueryMessageRequest $request)
    {
        $queryMessage = QueryMessage::create($request->all());

        return (new QueryMessageResource($queryMessage))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(QueryMessage $queryMessage)
    {
        abort_if(Gate::denies('query_message_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new QueryMessageResource($queryMessage->load(['query', 'report', 'created_by']));
    }

    public function update(UpdateQueryMessageRequest $request, QueryMessage $queryMessage)
    {
        $queryMessage->update($request->all());

        return (new QueryMessageResource($queryMessage))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(QueryMessage $queryMessage)
    {
        abort_if(Gate::denies('query_message_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $queryMessage->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
