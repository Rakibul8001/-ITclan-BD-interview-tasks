<?php

namespace App\Models;

use App\Models\Idea;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tournament extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function ideas()
    {
        return $this->belongsToMany(Idea::class, 'idea_tournament');
    }
}
