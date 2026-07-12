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
        Schema::create('tbl_master_material_sub_group1', function (Blueprint $table) {
            $table->unsignedInteger('id', 11)->autoIncrement();
            $table->string('code',50)->index('sub_group1_index');
            $table->string('name',50);
            $table->string('material_group',50)->nullable();
            $table->foreign('material_group')->references('code')->on('tbl_master_material_group')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('form_type',['FG Trading','Valuated','Non-Valuated'])->nullable();
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
        Schema::dropIfExists('tbl_master_material_sub_group1');
    }
};
