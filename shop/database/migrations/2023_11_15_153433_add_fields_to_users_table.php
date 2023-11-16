<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
           
            $table->string('phone')->nullable()->after('name'); // Thêm trường phone sau trường name
            $table->string('address')->nullable()->after('phone'); // Thêm trường address sau trường phone
            $table->string('gender')->nullable()->after('address'); // Thêm trường gender sau trường address
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
