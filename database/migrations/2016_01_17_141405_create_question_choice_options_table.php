<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestionChoiceOptionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('question_choice_options', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('question_id');
			$table->foreign('question_id')->references('id')->on('questions');
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
		Schema::drop('question_choice_options');
	}

}
