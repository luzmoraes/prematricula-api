<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsiblesStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responsibles_students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('responsible_id');
            $table->unsignedBigInteger('student_id');
            $table->timestamps();

            $table->foreign('responsible_id')->references('id')->on('responsibles');
            $table->foreign('student_id')->references('id')->on('students');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('responsibles_students');
    }
}
