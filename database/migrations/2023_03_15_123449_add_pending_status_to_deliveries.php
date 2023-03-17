<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::table('deliveries', function (Blueprint $table) {
            DB::statement("ALTER TABLE `deliveries` CHANGE `status` `status` ENUM('in-progress','delivered','pending') NOT NULL DEFAULT 'pending'");
        });

        // ALTER TABLE `deliveries` CHANGE `status` `status` ENUM('in-progress','delivered','pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'in-progress'; 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deliveries', function (Blueprint $table) {
            DB::statement("ALTER TABLE `deliveries` CHANGE `status` `status` ENUM('in-progress','delivered') NOT NULL DEFAULT 'in-progress'");
        });
    }
};
