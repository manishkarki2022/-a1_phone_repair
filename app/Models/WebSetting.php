<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebSetting extends Model
{
     protected $fillable = [
        'name',
        'moto',
        'logo',
        'favicon',
        'address',
        'phone',
        'email',
        'opening_closing_days',
        'primary_color',
        'secondary_color',
        'google_map_embed',
        'social_media',
        'copyright_text',
        'meta_title',
        'meta_description',
    ];
     protected $casts = [
        'opening_closing_days' => 'array',
        'social_media' => 'array',
    ];
    protected $table = 'web_settings';
    public $timestamps = true;
}
