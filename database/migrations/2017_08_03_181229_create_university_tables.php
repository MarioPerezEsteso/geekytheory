<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUniversityTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('teacher_id')->unsigned();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('description');
            $table->string('image');
            $table->enum('difficulty', array('beginner', 'intermediate', 'advanced'));
            $table->integer('duration')->default(0);
            $table->integer('students')->default(0);
            $table->boolean('free')->default(false);
            $table->enum('status', array('pending', 'draft', 'deleted', 'published', 'scheduled'));
            $table->timestamps();
            $table->softDeletes();

            // FK to table users to know the teacher of the course
            $table->foreign('teacher_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade');
        });

        Schema::create('chapters', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('course_id')->unsigned();
            $table->string('title');
            $table->integer('order');
            $table->timestamps();
            $table->softDeletes();

            // FK to table courses
            $table->foreign('course_id')
                ->references('id')
                ->on('courses')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::create('lessons', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('chapter_id')->unsigned();
            $table->string('slug')->unique();
            $table->string('title');
            $table->text('content');
            $table->string('video');
            $table->integer('order');
            $table->integer('duration');
            $table->boolean('free')->default(false);
            $table->timestamps();
            $table->softDeletes();

            // FK to table chapters
            $table->foreign('chapter_id')
                ->references('id')
                ->on('chapters')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });


        Schema::create('users_courses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('course_id');
            $table->timestamps();

            $table->unique(array('user_id', 'course_id'));

            // Foreign key to users
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // Foreign key to courses
            $table->foreign('course_id')
                ->references('id')
                ->on('courses')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::create('users_lessons', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('lesson_id');
            $table->timestamps();

            $table->unique(array('user_id', 'lesson_id'));

            // Foreign key to users
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // Foreign key to courses
            $table->foreign('lesson_id')
                ->references('id')
                ->on('lessons')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::create('courses_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('course_id');
            $table->unsignedInteger('category_id');
            $table->timestamps();

            $table->unique(array('course_id', 'category_id'));

            // Foreign key to courses
            $table->foreign('course_id')
                ->references('id')
                ->on('courses')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            // Foreign key to categories
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_courses');
        Schema::dropIfExists('users_lessons');
        Schema::dropIfExists('courses_categories');
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('chapters');
        Schema::dropIfExists('courses');
    }
}
