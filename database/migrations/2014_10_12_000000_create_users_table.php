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
        Schema::create('users', function (Blueprint $table) {
            $table->unsignedInteger('id', 11)->autoIncrement();
            $table->string('first_name');
            $table->string('last_name');
            $table->integer('status')->default(1);
            $table->string('email')->unique();
            $table->unsignedInteger('level')->index()->nullable();
            $table->foreign('level')->references('id')->on('tbl_master_user_level')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('department')->index()->nullable();
            $table->foreign('department')->references('id')->on('tbl_master_user_department')->onUpdate('cascade')->onDelete('cascade');
            $table->string('plant',10)->index()->nullable();
            $table->foreign('plant')->references('code')->on('tbl_master_plant')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
