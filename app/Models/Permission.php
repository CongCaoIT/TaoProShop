<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Permission extends Authenticatable
{
    use HasFactory, QueryScopes;

    protected $fillable = [
        'name',
        'canonical',
    ];

    protected $table = 'permissions';

    public function user_catalogues()
    {
        return $this->belongsToMany(UserCatalogue::class, 'user_catalogue_permission', 'permission_id', 'user_catalogue_id');
    }
}
