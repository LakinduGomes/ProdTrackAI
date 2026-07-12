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
        Schema::create('tbl_fg_trading_supply_chain', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fg_trading_id');
            $table->foreign('fg_trading_id')->references('id')->on('tbl_fg_trading')->onUpdate('cascade')->onDelete('cascade');

            $table->string('plant',10)->nullable();
            $table->foreign('plant')->references('code')->on('tbl_master_plant')->onUpdate('cascade')->onDelete('cascade');
            $table->string('storage_location',10)->nullable();
            $table->foreign('storage_location')->references('code')->on('tbl_master_material_storage_location')->onUpdate('cascade')->onDelete('cascade');

            $table->string('profit_center',10)->nullable();
            $table->foreign('profit_center')->references('code')->on('tbl_master_material_profit_center')->onUpdate('cascade')->onDelete('cascade');
            $table->string('sales_organization',10)->nullable();
            $table->foreign('sales_organization')->references('code')->on('tbl_master_material_sales_organization')->onUpdate('cascade')->onDelete('cascade');
            $table->string('distribution_channel',10)->nullable();
            $table->foreign('distribution_channel')->references('code')->on('tbl_master_material_distribution_channel')->onUpdate('cascade')->onDelete('cascade');

            $table->enum('request_type',['Create','Update','Extend'])->default('Create');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_fg_trading_supply_chain');
    }
};
