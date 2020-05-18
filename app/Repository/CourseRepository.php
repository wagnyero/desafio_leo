<?php

namespace App\Repository;

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
}
