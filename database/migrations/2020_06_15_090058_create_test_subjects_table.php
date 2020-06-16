<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_subjects', function (Blueprint $table) {
            $table->id();
            $table->string('header')->nullable();
            $table->enum('type', [0, 1]);
            $table->enum('status', [0, 1, 2, 3])->default(0);
            $table->string('path')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('created_by');

            $table->foreign('created_by')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_subjects');
    }
}
