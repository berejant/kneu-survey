<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnswersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('answers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('question_id');
			$table->foreign('question_id')->references('id')->on('questions');
			$table->unsignedInteger('question_choice_option_id')->nullable();
			$table->foreign('question_choice_option_id')->references('id')->on('question_choice_options');
			$table->unsignedInteger('questionnaire_id');
			$table->foreign('questionnaire_id')->references('id')->on('questionnaires');
			$table->text('text');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('answers');
	}

}
