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
        Schema::dropIfExists('tbl_master_material_type');

        Schema::create('tbl_master_material_type', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('code', 50)->index(); // Unique constraint, no need for separate index
            $table->string('name', 50);
            $table->enum('form_type',['FG/TRADING','SL_VALUATED','SL_NON_VALUATED'])->nullable();
            $table->integer('status')->default(1);
            $table->integer('created_by',)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_master_material_type');
    }
};
