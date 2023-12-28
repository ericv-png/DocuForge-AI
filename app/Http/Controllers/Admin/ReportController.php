<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyReportRequest;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Models\Query;
use App\Models\QueryMessage;
use App\Models\Report;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('report_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Report::with(['query', 'query_message', 'created_by'])->select(sprintf('%s.*', (new Report)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'report_show';
                $editGate      = 'report_edit';
                $deleteGate    = 'report_delete';
                $crudRoutePart = 'reports';

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
            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : '';
            });
            $table->addColumn('query_name', function ($row) {
                return $row->query ? $row->query->name : '';
            });

            $table->addColumn('query_message_message', function ($row) {
                return $row->query_message ? $row->query_message->message : '';
            });

            $table->editColumn('generated_file', function ($row) {
                if (! $row->generated_file) {
                    return '';
                }
                $links = [];
                foreach ($row->generated_file as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank">' . trans('global.downloadFile') . '</a>';
                }

                return implode(', ', $links);
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? Report::STATUS_SELECT[$row->status] : '';
            });
            $table->editColumn('tokens', function ($row) {
                return $row->tokens ? $row->tokens : '';
            });
            $table->editColumn('ai_model', function ($row) {
                return $row->ai_model ? $row->ai_model : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'query', 'query_message', 'generated_file']);

            return $table->make(true);
        }

        return view('admin.reports.index');
    }

    public function create()
    {
        abort_if(Gate::denies('report_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $queries = Query::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $query_messages = QueryMessage::pluck('message', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.reports.create', compact('queries', 'query_messages'));
    }

    public function store(StoreReportRequest $request)
    {
        $report = Report::create($request->all());

        foreach ($request->input('generated_file', []) as $file) {
            $report->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('generated_file');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $report->id]);
        }

        return redirect()->route('admin.reports.index');
    }

    public function edit(Report $report)
    {
        abort_if(Gate::denies('report_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $queries = Query::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $query_messages = QueryMessage::pluck('message', 'id')->prepend(trans('global.pleaseSelect'), '');

        $report->load('query', 'query_message', 'created_by');

        return view('admin.reports.edit', compact('queries', 'query_messages', 'report'));
    }

    public function update(UpdateReportRequest $request, Report $report)
    {
        $report->update($request->all());

        if (count($report->generated_file) > 0) {
            foreach ($report->generated_file as $media) {
                if (! in_array($media->file_name, $request->input('generated_file', []))) {
                    $media->delete();
                }
            }
        }
        $media = $report->generated_file->pluck('file_name')->toArray();
        foreach ($request->input('generated_file', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $report->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('generated_file');
            }
        }

        return redirect()->route('admin.reports.index');
    }

    public function show(Report $report)
    {
        abort_if(Gate::denies('report_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $report->load('query', 'query_message', 'created_by');

        return view('admin.reports.show', compact('report'));
    }

    public function destroy(Report $report)
    {
        abort_if(Gate::denies('report_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $report->delete();

        return back();
    }

    public function massDestroy(MassDestroyReportRequest $request)
    {
        $reports = Report::find(request('ids'));

        foreach ($reports as $report) {
            $report->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('report_create') && Gate::denies('report_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Report();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
