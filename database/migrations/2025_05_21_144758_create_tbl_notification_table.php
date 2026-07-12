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
        Schema::create('tbl_notification', function (Blueprint $table) {
            $table->id('id');
            $table->enum('form_type',['FG Trading','Valuated','Non-Valuated','Customer','Vendor'])->nullable();
            $table->string('notification')->unique();
            $table->string('url')->nullable();
            $table->enum('status',['unRead','Read'])->default('unRead');
            $table->integer('user')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_notification');
    }
};
