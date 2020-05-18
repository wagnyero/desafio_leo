<?php

namespace App\Repository;

use App\CoursePhoto;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CourseRepository extends AbstractRepository
{
    public function validationUpdate($request, $id) {
        return $request->validate([
            "title" => [
                "required",
                "max:60",
                "min:2",
                Rule::unique("courses")->ignore($id),
            ],
            "description" => ["required", "max:200", "min:2"],
            "link_slide_show" => ["required", "max:200", "min:2"],
        ]);
    }

    public function removeAllPhotosFromCourse($courseId) {
        try {
            $photos = CoursePhoto::where("course_id", $courseId)->get();

            foreach($photos as $photo) {
                Storage::disk("public")->delete($photo->photo);
                $photo->delete();
            }

            return true;
        } catch (QueryException $e) {
            return false;
        }
    }
}
