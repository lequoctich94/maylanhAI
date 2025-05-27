<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['user_id']);
            
            // Modify the column
            $table->foreignId('user_id')->nullable()->change();
            
            // Add new foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop foreign key constraint
            $table->dropForeign(['user_id']);
            
            // Revert the column to not nullable
            $table->foreignId('user_id')->nullable(false)->change();
            
            // Add back original foreign key constraint
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
}; 