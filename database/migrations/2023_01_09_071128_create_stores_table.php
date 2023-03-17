<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            // $table->bigInteger('id')->unsigned()->autoIncrement()->primary();
            // $table->unsignedBigInteger('id')->autoIncrement()->primary();
            // $table->bigIncrements('id')->primary();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text("description");
            $table->string("logo")->nullable();
            $table->enum("status",["active",'inactive'])->default("inactive");
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
        Schema::dropIfExists('stores');
    }
};
