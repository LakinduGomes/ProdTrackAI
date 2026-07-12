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

        Schema::create('tbl_migration_material', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_ref_id')->nullable();
            $table->string('material')->nullable();
            $table->string('material_type')->nullable();
            $table->string('plnt')->nullable();
            $table->string('storage_location')->nullable();
            $table->string('material_description')->nullable();
            $table->string('base_unit_of_measure')->nullable();
            $table->string('matl_group')->nullable();
            $table->string('valuation_class')->nullable();
            $table->string('profit_centre')->nullable();
            $table->string('mrp')->nullable();
            $table->string('typ')->nullable();
            $table->string('reorder_point')->nullable();
            $table->string('max_lot_size')->nullable();
            $table->string('safety_stock')->nullable();
            $table->string('created_by')->nullable();
            $table->string('created')->nullable();
            $table->string('last_chg')->nullable();
            $table->string('changed_by')->nullable();
            $table->string('client_level_block')->nullable();
            $table->string('valid_to')->nullable();
            $table->string('pland_level_block')->nullable();
            $table->string('valuation_category')->nullable();
            $table->string('valuation_type')->nullable();
            $table->string('delete_flag')->nullable();
            $table->enum('form_type', ['fg_trading', 'valuated', 'non_valuated'])->nullable();
            $table->enum('main_sync_status', ['Pending', 'sync'])->default('Pending');
            $table->enum('detail_sync_status', ['Pending', 'sync'])->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_migration_material');
    }
};
