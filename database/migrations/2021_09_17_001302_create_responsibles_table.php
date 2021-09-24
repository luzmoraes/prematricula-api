<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponsiblesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responsibles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('cpf')->unique();
            $table->string('rg')->unique()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('cep', 8)->nullable();
            $table->string('address', 255);
            $table->string('number', 10);
            $table->string('neighborhood', 255);
            $table->string('city', 255);
            $table->string('state', 2);
            $table->string('complement', 255)->nullable();
            $table->string('nationality', 255);
            $table->string('profession', 255);
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
        Schema::dropIfExists('responsibles');
    }
}
