<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Search extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'searches';

    protected $fillable = [
        'user_id',
        'engine_id',
        'language_id',
        'country_id',
        'keyword',
        'tag',
        'iterations',
        'device_type'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function engine()
    {
        return $this->belongsTo(Engine::class, 'engine_id', 'id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'search_id', 'id');
    }
}
