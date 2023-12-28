<?php

namespace App\Models;

use App\Traits\Auditable;
use App\Traits\MultiTenantModelTrait;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataCategory extends Model
{
    use SoftDeletes, MultiTenantModelTrait, Auditable, HasFactory;

    public $table = 'data_categories';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function categoryDataSources()
    {
        return $this->belongsToMany(DataSource::class);
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}