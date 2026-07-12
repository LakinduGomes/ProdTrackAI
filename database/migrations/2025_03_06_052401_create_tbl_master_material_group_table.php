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
        Schema::create('tbl_master_material_group', function (Blueprint $table) {
            $table->unsignedInteger('id', 11)->autoIncrement();
            $table->string('material_type',50);
            $table->foreign('material_type')->references('code')->on('tbl_master_material_type')->onUpdate('cascade')->onDelete('cascade');
            $table->string('code',50)->index('masterial_group_index');
            $table->string('name',50);
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
        Schema::dropIfExists('tbl_master_material_group');
    }
};
