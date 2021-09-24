<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('cpf')->unique()->nullable();
            $table->datetime('birthday');
            $table->string('blood_type', 3)->nullable();
            $table->string('race_color', 15)->nullable();
            $table->boolean('allergic')->default(false);
            $table->string('allergic_description', 255)->nullable();
            $table->string('cep', 8)->nullable();
            $table->string('address', 255);
            $table->string('number', 10);
            $table->string('neighborhood', 255);
            $table->string('city', 255);
            $table->string('state', 2);
            $table->string('complement', 255)->nullable();
            $table->string('father_name', 255)->nullable();
            $table->string('father_phone', 15);
            $table->string('mother_name', 255);
            $table->string('mother_phone', 15)->nullable();
            $table->string('authorized_responsibilities', 255)->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
