<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    public function projects()
{
    return $this->hasMany(Project::class);
}

public function posts()
{
    return $this->hasMany(Post::class);
}


}

