<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Course;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    private $course;

    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourseRequest $request)
    {
        try {
            $courseCreated = $this->course->create($request->all());

            if($request->hasFile("images")) {
                $imagesUploaded = [];

                foreach ($request->images as $image) {
                    $path = $image->store("images", "public");
                    $imagesUploaded[] = ["photo" => $path, "is_thumb" => false];
                }

                $courseCreated->coursePhoto()->createMany($imagesUploaded);
            }

            $message = new ApiMessages("Course successfully created");

            return response()->json($message->getMessage());

        } catch (QueryException $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
