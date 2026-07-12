<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('system_users', function (Blueprint $table) {
        $table->unsignedInteger('id', 11)->autoIncrement();
        $table->string('name');
        $table->string('email')->unique();
        $table->string('password');
        $table->boolean('status')->default(1);
        $table->timestamps();
    });

}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_users');
    }
};
