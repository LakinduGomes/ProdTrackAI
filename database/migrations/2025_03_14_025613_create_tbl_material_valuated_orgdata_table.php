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

        Schema::create('tbl_material_valuated_orgdata', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('valuated_id');
            $table->foreign('valuated_id')->references('id')->on('tbl_material_valuated')->onUpdate('cascade')->onDelete('cascade');

            $table->string('plant',10)->nullable();
            $table->foreign('plant')->references('code')->on('tbl_master_plant')->onUpdate('cascade')->onDelete('cascade');
            $table->string('storage_location',10)->nullable();
            $table->foreign('storage_location')->references('code')->on('tbl_master_material_storage_location')->onUpdate('cascade')->onDelete('cascade');
            $table->string('profit_center',10)->nullable();
            $table->foreign('profit_center')->references('code')->on('tbl_master_material_profit_center')->onUpdate('cascade')->onDelete('cascade');

            $table->enum('request_type',['Create','Update','Extend'])->default('Create');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_material_valuated_orgdata');
    }
};
