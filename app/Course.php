<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        "title", "description", "link_slide_show",
    ];

    public function coursePhoto()
    {
        return $this->hasMany(CoursePhoto::class);
    }
}
