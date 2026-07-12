<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tbl_fg_trading_mass', function (Blueprint $table) {
            $table->id();
            // Material Identification Data
            $table->string('material_type',50);
//            $table->foreign('material_type')->references('code')->on('tbl_master_material_type')->onUpdate('cascade')->onDelete('cascade');
            $table->string('material_code',50)->index()->nullable();
            $table->string('ref_material_code',50)->nullable();
            $table->enum('local_export',['Local', 'Export'])->nullable();
            $table->string('ref_green_type',50)->nullable();
            // Material Identification Data

            // Supply Chain Management Data
            //related with tbl_fg_trading_supply_chain table
            // Supply Chain Management Data
            $table->string('plant',50)->nullable();
//            $table->foreign('plant')->references('code')->on('tbl_master_plant')->onUpdate('cascade')->onDelete('cascade');
            $table->string('storage_location',50)->nullable();
//            $table->foreign('storage_location')->references('code')->on('tbl_master_storage_location')->onUpdate('cascade')->onDelete('cascade');
            $table->string('profit_center',50)->nullable();
//            $table->foreign('profit_center')->references('code')->on('tbl_master_profit_center')->onUpdate('cascade')->onDelete('cascade');

            //Basic Data
            $table->string('short_description',40)->unique();
            $table->string('long_description')->nullable();
            $table->string('unit_of_measure',10)->nullable();
//            $table->foreign('unit_of_measure')->references('code')->on('tbl_master_material_unit_of_measure')->onUpdate('cascade')->onDelete('cascade');
            //Basic Data

            //Marketing Data
            $table->string('material_group',10)->nullable();
//            $table->foreign('material_group')->references('code')->on('tbl_master_material_group')->onUpdate('cascade')->onDelete('cascade');
            $table->string('sub_group1',10)->nullable();
//            $table->foreign('sub_group1')->references('code')->on('tbl_master_material_sub_group1')->onUpdate('cascade')->onDelete('cascade');
            $table->string('sub_group2',10)->nullable();
//            $table->foreign('sub_group2')->references('code')->on('tbl_master_material_sub_group2')->onUpdate('cascade')->onDelete('cascade');
            $table->string('sub_group3',10)->nullable();
//            $table->foreign('sub_group3')->references('code')->on('tbl_master_material_sub_group3')->onUpdate('cascade')->onDelete('cascade');
            $table->string('sub_group4',10)->nullable();
//            $table->foreign('sub_group4')->references('code')->on('tbl_master_material_sub_group4')->onUpdate('cascade')->onDelete('cascade');
            $table->string('sub_group5',10)->nullable();
//            $table->foreign('sub_group5')->references('code')->on('tbl_master_material_sub_group5')->onUpdate('cascade')->onDelete('cascade');
            //Marketing Data

            //Financial Data
            $table->float('price',10,2)->default(0.00);
            $table->string('currency',10)->nullable();
//            $table->foreign('currency')->references('code')->on('tbl_master_material_currency')->onUpdate('cascade')->onDelete('cascade');
            $table->string('valuation_class',10)->nullable();
//            $table->foreign('valuation_class')->references('code')->on('tbl_master_material_valuation_class')->onUpdate('cascade')->onDelete('cascade');
            //Financial Data

            //Technical Data
            $table->string('weight',10,2)->default(0.00);
            $table->string('volume',10,2)->default(0.00);
            $table->string('nsd',10,2)->default(0.00);
            //Technical Data

            $table->string('special_note')->default('-')->nullable();
            $table->enum('approval_status',['Requested','Level1 Approved','Level2 Approved','Level3 Approved','Approved','Rejected'])->default('Requested');
            $table->string('reject_reason')->default('-');
            $table->string('date_time');

            //add two columns to current level and next level according to the workflow
            $table->string('current_level');
            $table->string('next_level');
            //add two columns to current level and next level according to the workflow

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->enum('request_type',['Create','Update','Extend'])->default('Create');
            $table->integer('level1_approved_by')->nullable();
            $table->integer('level2_approved_by')->nullable();
            $table->integer('level3_approved_by')->nullable();
            $table->integer('level4_approved_by')->nullable();
            $table->integer('level5_approved_by')->nullable();
            $table->integer('level6_approved_by')->nullable();
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_fg_trading_mass');
    }
};
