<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory, QueryScopes;

    protected $fillable = [
        'name'
    ];

    protected $table = 'districts';
    protected $primaryKey = 'code';
    public $incrementing = false;

    public function provinces()
    {
        return $this->belongsTo(Province::class, 'province_code', 'code');
    }

    public function wards()
    {
        return $this->hasMany(Ward::class, 'district_code', 'code');
    }
}
