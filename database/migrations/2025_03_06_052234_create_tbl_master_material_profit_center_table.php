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
        Schema::create('tbl_master_material_profit_center', function (Blueprint $table) {
            $table->unsignedInteger('id', 11)->autoIncrement();
            $table->string('code',50)->unique()->index('master_material_profit_center_index');
            $table->string('name',50)->unique();
            $table->string('plant',50);
            $table->foreign('plant')->references('code')->on('tbl_master_plant')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_master_material_profit_center');
    }
};
