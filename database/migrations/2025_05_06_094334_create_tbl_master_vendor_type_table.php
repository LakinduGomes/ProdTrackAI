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
        Schema::create('tbl_master_vendor_type', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('code', 50)->index(); // Unique constraint, no need for separate index
            $table->string('name', 50);
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_master_vendor_type');
    }
};
