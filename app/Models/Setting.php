<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\MultiTenantModelTrait;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Setting extends Model implements HasMedia
{
    use SoftDeletes, MultiTenantModelTrait, InteractsWithMedia, Auditable, HasFactory;

    public $table = 'settings';

    protected $appends = [
        'org_logo',
    ];

    public const TEXT_FILE_PROCESSING_SELECT = [
        'local' => 'Local',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const AI_SERVICE_PROVIDER_SELECT = [
        'openai'       => 'OpenAI',
        'azure-openai' => 'Azure OpenAI',
    ];

    public const IMAGE_FILE_PROCESSING_SELECT = [
        'local' => 'Local',
        'gcv'   => 'Google Cloud Vision',
        'acv'   => 'Azure Computer Vision',
    ];

    protected $fillable = [
        'org_name',
        'footer_text',
        'registration_admin_approve',
        'ai_service_provider',
        'ai_service_provider_credentials',
        'ai_processing_model',
        'api_status',
        'image_file_processing',
        'image_file_processing_model',
        'image_file_processing_credentials',
        'text_file_processing',
        'text_file_processing_model',
        'text_file_processing_credentials',
        'mail_credentials',
        'host_url',
        'created_at',
        'moderation',
        'registration',
        'max_report_simu_process',
        'max_data_source_simu_process',
        'updated_at',
        'deleted_at',
        'created_by_id',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function getOrgLogoAttribute()
    {
        $file = $this->getMedia('org_logo')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}
