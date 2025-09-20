<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialPlatform extends Model
{
    protected $fillable = ['name', 'key', 'icon', 'color', 'base_url'];
}
