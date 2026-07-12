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

        Schema::create('tbl_master_user_modules_workflows', function (Blueprint $table) {
            $table->unsignedInteger('id', 11)->autoIncrement();
            $table->integer('level')->unsigned()->nullable();
            $table->foreign('level')->references('id')->on('tbl_master_user_level')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('module')->unsigned()->nullable();
            $table->foreign('module')->references('id')->on('tbl_master_user_modules')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('user')->unsigned()->nullable();
            $table->foreign('user')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_master_user_modules_workflows');
    }
};
