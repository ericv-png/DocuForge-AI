<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroySettingRequest;
use App\Http\Requests\StoreSettingRequest;
use App\Http\Requests\UpdateSettingRequest;
use App\Models\Setting;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class SettingsController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('setting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Setting::with(['created_by'])->select(sprintf('%s.*', (new Setting)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'setting_show';
                $editGate      = 'setting_edit';
                $deleteGate    = 'setting_delete';
                $crudRoutePart = 'settings';

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
            $table->editColumn('org_name', function ($row) {
                return $row->org_name ? $row->org_name : '';
            });
            $table->editColumn('org_logo', function ($row) {
                if ($photo = $row->org_logo) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });
            $table->editColumn('registration_admin_approve', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->registration_admin_approve ? 'checked' : null) . '>';
            });
            $table->editColumn('ai_service_provider', function ($row) {
                return $row->ai_service_provider ? Setting::AI_SERVICE_PROVIDER_SELECT[$row->ai_service_provider] : '';
            });
            $table->editColumn('ai_service_provider_credentials', function ($row) {
                return $row->ai_service_provider_credentials ? $row->ai_service_provider_credentials : '';
            });
            $table->editColumn('ai_processing_model', function ($row) {
                return $row->ai_processing_model ? $row->ai_processing_model : '';
            });
            $table->editColumn('api_status', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->api_status ? 'checked' : null) . '>';
            });
            $table->editColumn('image_file_processing', function ($row) {
                return $row->image_file_processing ? Setting::IMAGE_FILE_PROCESSING_SELECT[$row->image_file_processing] : '';
            });
            $table->editColumn('image_file_processing_model', function ($row) {
                return $row->image_file_processing_model ? $row->image_file_processing_model : '';
            });
            $table->editColumn('image_file_processing_credentials', function ($row) {
                return $row->image_file_processing_credentials ? $row->image_file_processing_credentials : '';
            });
            $table->editColumn('text_file_processing', function ($row) {
                return $row->text_file_processing ? Setting::TEXT_FILE_PROCESSING_SELECT[$row->text_file_processing] : '';
            });
            $table->editColumn('text_file_processing_model', function ($row) {
                return $row->text_file_processing_model ? $row->text_file_processing_model : '';
            });
            $table->editColumn('text_file_processing_credentials', function ($row) {
                return $row->text_file_processing_credentials ? $row->text_file_processing_credentials : '';
            });
            $table->editColumn('mail_credentials', function ($row) {
                return $row->mail_credentials ? $row->mail_credentials : '';
            });
            $table->editColumn('host_url', function ($row) {
                return $row->host_url ? $row->host_url : '';
            });
            $table->editColumn('moderation', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->moderation ? 'checked' : null) . '>';
            });
            $table->editColumn('registration', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->registration ? 'checked' : null) . '>';
            });
            $table->editColumn('max_report_simu_process', function ($row) {
                return $row->max_report_simu_process ? $row->max_report_simu_process : '';
            });
            $table->editColumn('max_data_source_simu_process', function ($row) {
                return $row->max_data_source_simu_process ? $row->max_data_source_simu_process : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'org_logo', 'registration_admin_approve', 'api_status', 'moderation', 'registration']);

            return $table->make(true);
        }

        return view('admin.settings.index');
    }

    public function create()
    {
        abort_if(Gate::denies('setting_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.settings.create');
    }

    public function store(StoreSettingRequest $request)
    {
        $setting = Setting::create($request->all());

        if ($request->input('org_logo', false)) {
            $setting->addMedia(storage_path('tmp/uploads/' . basename($request->input('org_logo'))))->toMediaCollection('org_logo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $setting->id]);
        }

        return redirect()->route('admin.settings.index');
    }

    public function edit(Setting $setting)
    {
        abort_if(Gate::denies('setting_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $setting->load('created_by');

        return view('admin.settings.edit', compact('setting'));
    }

    public function update(UpdateSettingRequest $request, Setting $setting)
    {
        $setting->update($request->all());

        if ($request->input('org_logo', false)) {
            if (! $setting->org_logo || $request->input('org_logo') !== $setting->org_logo->file_name) {
                if ($setting->org_logo) {
                    $setting->org_logo->delete();
                }
                $setting->addMedia(storage_path('tmp/uploads/' . basename($request->input('org_logo'))))->toMediaCollection('org_logo');
            }
        } elseif ($setting->org_logo) {
            $setting->org_logo->delete();
        }

        return redirect()->route('admin.settings.index');
    }

    public function show(Setting $setting)
    {
        abort_if(Gate::denies('setting_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $setting->load('created_by');

        return view('admin.settings.show', compact('setting'));
    }

    public function destroy(Setting $setting)
    {
        abort_if(Gate::denies('setting_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $setting->delete();

        return back();
    }

    public function massDestroy(MassDestroySettingRequest $request)
    {
        $settings = Setting::find(request('ids'));

        foreach ($settings as $setting) {
            $setting->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('setting_create') && Gate::denies('setting_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Setting();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
