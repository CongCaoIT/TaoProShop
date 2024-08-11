<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory, QueryScopes;

    protected $fillable = [
        'name'
    ];

    protected $table = 'wards';
    protected $primaryKey = 'code';
    public $incrementing = false;

    public function districts()
    {
        return $this->belongsTo(District::class, 'district_code', 'code');
    }
}
