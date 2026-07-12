<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tbl_material_non_valuated', function (Blueprint $table) {
            $table->id();
            $table->integer('revision')->nullable();
            $table->enum('request_type',['Create','Update','Extend'])->default('Create');

            $table->string('material_type',50)->index();
            $table->foreign('material_type')->references('code')->on('tbl_master_material_type')->onUpdate('cascade')->onDelete('cascade');

            $table->string('material_code',50)->index()->nullable();

            $table->string('budget_type',10)->nullable();
            $table->foreign('budget_type')->references('code')->on('tbl_master_budget_type')->onUpdate('cascade')->onDelete('cascade');

            $table->string('short_description',40);
            $table->string('long_description')->nullable();

            $table->string('base_uom',10)->nullable();
            $table->foreign('base_uom')->references('code')->on('tbl_master_material_base_unit_of_measure')->onUpdate('cascade')->onDelete('cascade');

            $table->string('estimated_value',50)->nullable();

            $table->string('mrp_run',10)->nullable();
            $table->string('reorder_point',50)->nullable();
            $table->string('maximum_stock_level',50)->nullable();
            $table->string('safety_stock',50)->nullable();
            $table->string('purchasing_group',50)->nullable();
            $table->string('mrp_type',50)->nullable();
            $table->string('mrp_controller',50)->nullable();
            $table->string('lot_sizing',50)->nullable();

            $table->string('quality_activate',10)->nullable();
            $table->string('batch_management',10)->nullable();
            $table->string('min_rem_shelf_life',50)->nullable();
            $table->string('total_shelf_life',50)->nullable();

            $table->string('material_group',10)->nullable();
            $table->foreign('material_group')->references('code')->on('tbl_master_material_group')->onUpdate('cascade')->onDelete('cascade');

            $table->string('sub_group1',10)->nullable();
            $table->foreign('sub_group1')->references('code')->on('tbl_master_material_sub_group1')->onUpdate('cascade')->onDelete('cascade');

            $table->string('valuation_class',10)->nullable();
            $table->foreign('valuation_class')->references('code')->on('tbl_master_material_valuation_class')->onUpdate('cascade')->onDelete('cascade');

            $table->string('uom',10)->nullable();
            $table->foreign('uom')->references('code')->on('tbl_master_material_unit_of_measure')->onUpdate('cascade')->onDelete('cascade');

            $table->string('num_of_units',50)->nullable();

            $table->string('purchasing_order_unit',50)->nullable();
            $table->foreign('purchasing_order_unit')->references('code')->on('tbl_master_material_purchasing_order_unit')->onUpdate('cascade')->onDelete('cascade');

            $table->string('special_note')->default('-');
            $table->enum('approval_status',['Requested','Level1 Approved','Level2 Approved','Level3 Approved','Approved','Rejected'])->default('Requested');
            $table->string('reject_reason')->default('-');
            $table->string('date_time');
              //add two columns to current level and next level according to the workflow
              $table->string('current_level');
              $table->string('next_level');
              //add two columns to current level and next level according to the workflow

            $table->enum('sync_status',['Yes','No'])->default('No');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('level2_approved_by')->nullable();
            $table->integer('level3_approved_by')->nullable();
            $table->integer('level4_approved_by')->nullable();
            $table->integer('level5_approved_by')->nullable();
            $table->integer('level6_approved_by')->nullable();
            $table->integer('level7_approved_by')->nullable();
            $table->text('history')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_material_non_valuated');
    }
};
