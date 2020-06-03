<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('header')->nullable();
            $table->string('description')->nullable();
            $table->integer('class')->unique();
            $table->integer('time')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->string('note')->nullable();
            $table->integer('rating')->nullable();
            $table->enum('type', ['online', 'practice'])
                ->default('practice')
                ->nullable();
            $table->dateTime('start_time')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('subject_id')
                ->references('id')
                ->on('subjects');

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
        Schema::dropIfExists('exams');
    }
}
