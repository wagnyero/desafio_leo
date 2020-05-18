<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Course;
use App\CoursePhoto;
use App\Http\Controllers\Controller;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseCollection;
use App\Http\Resources\CourseResource;
use App\Repository\CourseRepository;
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
    public function index(Request $request)
    {
        try {
            $courseRepository = new CourseRepository($this->course);

            if($request->has("coditions")) {
                $courseRepository->selectCoditions($request->coditions);
            }

            if($request->has("fields")) {
                $courseRepository->selectFilter($request->fields);
            }

            return new CourseCollection($courseRepository->getResult()->with("coursePhoto")->paginate(10));
        } catch (QueryException $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
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
        try {
            $course = $this->course
                        ->with("coursePhoto")
                        ->findOrFail($id);

            return new CourseResource($course);
        } catch (QueryException $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
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
        try {
            $courseRepository = new CourseRepository($this->course);
            if($courseRepository->validationUpdate($request, $id)) {
                $course = $this->course->findOrFail($id);
                $course->update($request->all());

                if($request->hasFile("images")) {
                    $imagesUploaded = [];

                    foreach ($request->images as $image) {
                        $path = $image->store("images", "public");
                        $imagesUploaded[] = ["photo" => $path, "is_thumb" => false];
                    }

                    $course->coursePhoto()->createMany($imagesUploaded);
                }
            }

            $message = new ApiMessages("Course successfully updated");

            return response()->json($message->getMessage());
        } catch (QueryException $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $courseRepository = new CourseRepository($this->course);

            if($courseRepository->removeAllPhotosFromCourse($id)) {
                $course = $this->course->findOrFail($id);
                $course->delete();

                $message = new ApiMessages("Course successfully deleted");

                return response()->json($message->getMessage());
            }

            $message = new ApiMessages("Course is not deleted");
            return response()->json($message->getMessage(), 500);

        } catch (QueryException $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}
