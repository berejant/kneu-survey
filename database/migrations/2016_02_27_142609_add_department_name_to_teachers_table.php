<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDepartmentNameToTeachersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('teachers', function(Blueprint $table)
		{
			$table->text('department_name')->after('photo');
			$table->text('disciplines')->after('department_name');
			$table->text('courses')->after('disciplines');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('teachers', function(Blueprint $table)
		{
			$table->dropColumn('department_name');
			$table->dropColumn('disciplines');
			$table->dropColumn('courses');
		});
	}

}
