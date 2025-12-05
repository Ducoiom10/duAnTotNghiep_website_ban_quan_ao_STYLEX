<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppData extends Model
{
    //
    protected $fillable = [
        'logo_text',
        'heading',
        'location',
        'email',
        'phone',
        'facebook',
        'instagram'
    ];
}
