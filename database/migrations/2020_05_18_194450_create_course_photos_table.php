<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursePhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("course_id");
            $table->string("photo");
            $table->boolean("is_thumb");
            $table->timestamps();
            $table->foreign("course_id")->references("id")->on("courses");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_photos');
    }
}
