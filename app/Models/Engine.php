<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Engine extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'engines';

    protected $fillable = ['title', 'slug', 'task_url', 'items_url'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
