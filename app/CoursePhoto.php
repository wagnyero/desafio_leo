<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoursePhoto extends Model
{
    protected $fillable = [
        "photo", "is_thumb",
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
