<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->foreign('supervisor_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('session_id')->references('id')->on('course_sessions')->onDelete('set null');

        });

        Schema::table('choices', function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('users');
            $table->foreign('project1')->references('id')->on('projects')->onDelete('set null');
            $table->foreign('project2')->references('id')->on('projects')->onDelete('set null');
            $table->foreign('project3')->references('id')->on('projects')->onDelete('set null');
            $table->foreign('session_id')->references('id')->on('course_sessions')->onDelete('cascade');
        });

        Schema::table('interests', function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
