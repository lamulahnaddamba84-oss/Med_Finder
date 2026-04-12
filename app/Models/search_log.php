<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class search_log extends Model
{
    protected $fillable = ['search_query', 'user_id', 'is_found'];
}
