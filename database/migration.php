<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function __construct()
	{
		$this->tablename = config('setting.table');
		$this->keyColumn = config('setting.keyColumn');
		$this->valueColumn = config('setting.valueColumn');
	}

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(): void
	{
		Schema::create($this->tablename, function (Blueprint $table) {
			$table->id();
			$table->string($this->keyColumn);
			$table->text($this->valueColumn);
			// Your coustem filld
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists($this->tablename);
	}
};
