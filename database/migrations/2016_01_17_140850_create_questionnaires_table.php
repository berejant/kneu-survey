<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionnairesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('questionnaires', function(Blueprint $table)
		{
			$table->increments('id');
			$table->char('student_id', 8);
			$table->unsignedInteger('teacher_id');
			$table->tinyInteger('academic_year')->unsigned();
			$table->tinyInteger('semester')->unsigned();
			$table->foreign('student_id')->references('id')->on('students');
			$table->foreign('teacher_id')->references('id')->on('teachers');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('questionnaires');
	}

}
