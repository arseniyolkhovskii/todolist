<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    protected $table = 'categories';
    protected $guarded = false;

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
