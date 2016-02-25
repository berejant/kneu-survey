<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionResultsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('question_results', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('question_id');
			$table->foreign('question_id')->references('id')->on('questions');
			$table->unsignedInteger('question_choice_option_id')->nullable();
			$table->foreign('question_choice_option_id')->references('id')->on('question_choice_options');
			$table->unsignedInteger('teacher_id');
			$table->foreign('teacher_id')->references('id')->on('teachers');
			$table->mediumInteger('academic_year')->unsigned();
			$table->tinyInteger('semester')->unsigned();
			$table->unsignedInteger('count');
			$table->float('portion', 6, 3)->comment('Доля в процентах');
			$table->timestamps();
			$table->unique([
				'academic_year',
				'semester',
				'teacher_id',
				'question_id',
				'question_choice_option_id',
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
		Schema::drop('question_results');
	}

}
