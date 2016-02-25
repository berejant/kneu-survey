<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeacherResultsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teacher_results', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('teacher_id');
            $table->foreign('teacher_id')->references('id')->on('teachers');
            $table->mediumInteger('academic_year')->unsigned();
            $table->tinyInteger('semester')->unsigned();
            $table->enum('type', ['total', 'fill', 'skip'])->default('total');
            $table->unsignedInteger('count');
            $table->float('portion', 6, 3)->comment('Доля в процентах');
            $table->timestamps();
            $table->unique([
                'academic_year', 'semester',
                'teacher_id', 'type',
            ], 'unique_result');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('teacher_results');
    }

}
