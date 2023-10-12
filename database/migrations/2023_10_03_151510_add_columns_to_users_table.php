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
            //
            $table->after('password', function (Blueprint $table) {
                $table->string('phone',11)->unique()->nullable();
                $table->mediumInteger('code')->length(5)->nullable();
                $table->timestamp('code_expired_at')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn(['code','code_expired_at']);
            //$table->dropUnique('phone');
        });
    }
};
