<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
    protected $table = 'labels';
    protected $guarded = false;

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_labels');
    }
}
