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

class DataSource extends Model implements HasMedia
{
    use SoftDeletes, MultiTenantModelTrait, InteractsWithMedia, Auditable, HasFactory;

    public $table = 'data_sources';

    protected $appends = [
        'file',
    ];

    public static $searchable = [
        'name',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const TYPE_SELECT = [
        'img'  => 'Image',
        'text' => 'Text File',
        'url'  => 'URL',
    ];

    public const STATUS_SELECT = [
        'u' => 'uploaded',
        'p' => 'Processing',
        'r' => 'ready',
        'e' => 'Error',
    ];

    protected $fillable = [
        'reference',
        'name',
        'type',
        'url',
        'created_at',
        'status',
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

    public function dataSourceQueries()
    {
        return $this->belongsToMany(Query::class);
    }

    public function categories()
    {
        return $this->belongsToMany(DataCategory::class);
    }

    public function getFileAttribute()
    {
        return $this->getMedia('file')->last();
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}
