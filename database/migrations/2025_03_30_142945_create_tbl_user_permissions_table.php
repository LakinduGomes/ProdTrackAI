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
        Schema::create('tbl_user_permissions', function (Blueprint $table) {
            $table->unsignedInteger('id', 11)->autoIncrement();
            $table->unsignedInteger('user')->index()->nullable();
            $table->foreign('user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('module')->index()->nullable();
            $table->foreign('module')->references('id')->on('tbl_master_user_modules')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('add_permission',['Yes','No'])->nullable();
            $table->enum('edit_permission',['Yes','No'])->nullable();
            $table->enum('delete_permission',['Yes','No'])->nullable();
            $table->enum('approve_permission',['Yes','No'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_user_permissions');
    }
};
