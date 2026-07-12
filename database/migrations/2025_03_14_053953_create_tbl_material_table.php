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
        Schema::create('tbl_material', function (Blueprint $table) {
            $table->id();
            $table->string('material_code')->nullable();
            $table->string('short_description')->nullable();
            $table->bigInteger('ref_id')->nullable();
            $table->string('delete_flag')->nullable()->default(' ');//default delete flag is 0
            $table->enum('form_type',['FG Trading','Valuated','Non-Valuated'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_material');
    }
};
