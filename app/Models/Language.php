<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\QueryScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Language extends Authenticatable
{
    use HasFactory, SoftDeletes, QueryScopes;

    protected $fillable = [
        'name',
        'canonical',
        'publish',
        'user_id',
        'image',
        'description',
        'current'
    ];

    protected $table = 'languages';

    public function languages()
    {
        return $this->belongsToMany(PostCatalogue::class, 'post_catalogue_language', 'language_id', 'post_catalogue_id')
            ->withPivot(
                'name',
                'canonical',
                'meta_title',
                'meta_keyword',
                'meta_description',
                'description',
                'content'
            )
            ->withTimestamps();
    }
}
