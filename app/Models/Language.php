<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Language extends Authenticatable
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'canonical',
        'publish',
        'user_id',
        'image',
        'description'
    ];

    protected $table = 'languages';
}
