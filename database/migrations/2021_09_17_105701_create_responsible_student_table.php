<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsibleStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responsible_student', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('responsible_id');
            $table->unsignedBigInteger('student_id');
            $table->string('relationship', 15);
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
        Schema::dropIfExists('responsible_student');
    }
}
