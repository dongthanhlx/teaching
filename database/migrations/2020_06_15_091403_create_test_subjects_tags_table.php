<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestSubjectsTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('test_subjects_tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('test_subject_id');
            $table->unsignedBigInteger('tag_id');
            $table->timestamps();

            $table->foreign('test_subject_id')
                ->references('id')
                ->on('test_subjects');

            $table->foreign('tag_id')
                ->references('id')
                ->on('tags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('test_subjects_tags');
    }
}
