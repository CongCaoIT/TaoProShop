<?php

namespace App\Models;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory, QueryScopes;

    protected $fillable = [
        'name'
    ];

    protected $table = 'provinces';
    protected $primaryKey = 'code';
    public $incrementing = false;

    public function districts()
    {
        return $this->hasMany(District::class, 'province_code', 'code');
    }
}
