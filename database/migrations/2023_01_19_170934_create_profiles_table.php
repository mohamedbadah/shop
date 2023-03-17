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
        Schema::create('profiles', function (Blueprint $table) {
            $table->foreignId("user_id")->constrained("users")->cascadeOnDelete();
            $table->string("first_name");
            $table->string("last_name");
            $table->string("city")->nullable();
            $table->date("birthday")->nullable();
            $table->enum("gender",["male","female"]);
            $table->string("street_address")->nullable();
            $table->string("status")->nullable();
            $table->string("postal_code")->nullable();
            $table->char("country",2);
            $table->char("locale",2)->default("en");
            $table->primary("user_id");
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
        Schema::dropIfExists('profiles');
    }
};
