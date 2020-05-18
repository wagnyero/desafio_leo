<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id"                => $this->id,
            "title"             => $this->title,
            "description"       => $this->description,
            "link_slide_show"   => $this->link_slide_show,
            "course_photo"      => $this->coursePhoto,
        ];
    }
}
