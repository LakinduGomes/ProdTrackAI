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
        Schema::create('tbl_master_material_base_unit_of_measure', function (Blueprint $table) {
            $table->unsignedInteger('id', 11)->autoIncrement();
            $table->string('code',50)->unique()->index('material_unit_index');
            $table->string('name',50)->unique();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('tbl_master_material_base_unit_of_measure');
    }
};
