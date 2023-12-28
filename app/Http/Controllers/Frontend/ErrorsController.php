<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyErrorRequest;
use App\Http\Requests\StoreErrorRequest;
use App\Http\Requests\UpdateErrorRequest;
use App\Models\Error;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ErrorsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('error_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $errors = Error::with(['query', 'data_source', 'created_by'])->get();

        return view('frontend.errors.index', compact('errors'));
    }

    public function create()
    {
        abort_if(Gate::denies('error_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('frontend.errors.create');
    }

    public function store(StoreErrorRequest $request)
    {
        $error = Error::create($request->all());

        return redirect()->route('frontend.errors.index');
    }

    public function edit(Error $error)
    {
        abort_if(Gate::denies('error_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $error->load('query', 'data_source', 'created_by');

        return view('frontend.errors.edit', compact('error'));
    }

    public function update(UpdateErrorRequest $request, Error $error)
    {
        $error->update($request->all());

        return redirect()->route('frontend.errors.index');
    }

    public function show(Error $error)
    {
        abort_if(Gate::denies('error_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $error->load('query', 'data_source', 'created_by');

        return view('frontend.errors.show', compact('error'));
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
