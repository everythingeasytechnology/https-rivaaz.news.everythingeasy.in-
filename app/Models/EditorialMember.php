<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EditorialMember extends Model
{
    protected $fillable = [
        'name',
        'designation',
        'avatar',
        'bio',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
