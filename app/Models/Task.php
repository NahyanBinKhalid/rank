<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tasks';

    protected $fillable = [
        'search_id',
        'task_uuid',
        'task_cost',
        'search_engine',
        'search_engine_type',
        'engine_results_count',
        'request_os',
        'items_count'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function search()
    {
        return $this->belongsTo(Search::class, 'search_id', 'id');
    }

    public function items()
    {
        return $this->belongsTo(Item::class, 'task_id', 'id');
    }
}
