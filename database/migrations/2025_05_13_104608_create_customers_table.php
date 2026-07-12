<?php

use GuzzleHttp\Promise\Create;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tbl_customers', function (Blueprint $table) {

            $table->id();
            $table->string('customer_code')->unique();  // Customer ID
            $table->string('bp_type', 50)->index();
            $table->foreign('bp_type')->references('code')->on('tbl_master_customer_bp_type')->onUpdate('cascade')->onDelete('cascade');
            $table->string('term1', 50)->index()->nullable();
            $table->foreign('term1')->references('code')->on('tbl_master_customer_term1')->onUpdate('cascade')->onDelete('cascade');
            $table->string('term2', 50)->index()->nullable();
            $table->foreign('term2')->references('code')->on('tbl_master_customer_term2')->onUpdate('cascade')->onDelete('cascade');
            $table->string('payment_term', 50)->index()->nullable();
            $table->foreign('payment_term')->references('code')->on('tbl_master_customer_payment_terms')->onUpdate('cascade')->onDelete('cascade');
            $table->string('house_no');

            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->integer('postal_code')->nullable();
            $table->string('city', 50)->index()->nullable();
            $table->foreign('city')->references('code')->on('tbl_master_customer_city')->onUpdate('cascade')->onDelete('cascade');
            $table->string('district', 50)->index()->nullable();
            $table->foreign('district')->references('code')->on('tbl_master_customer_district')->onUpdate('cascade')->onDelete('cascade');
            $table->string('region', 50)->index()->nullable();
            $table->foreign('region')->references('code')->on('tbl_master_customer_region')->onUpdate('cascade')->onDelete('cascade');
            $table->string('country', 50)->index()->nullable();
            $table->foreign('country')->references('code')->on('tbl_master_customer_country')->onUpdate('cascade')->onDelete('cascade');
            $table->string('telephone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->unique();
            $table->string('proprietor')->nullable();
            $table->string('distribution_channel')->index()->nullable();
            $table->foreign('distribution_channel')->references('code')->on('tbl_master_material_distribution_channel')->onUpdate('cascade')->onDelete('cascade');
            $table->string('customer_group')->index()->nullable();
            $table->foreign('customer_group')->references('code')->on('tbl_master_customer_group')->onUpdate('cascade')->onDelete('cascade');
            $table->string('sales_office')->index()->nullable();
            $table->foreign('sales_office')->references('code')->on('tbl_master_customer_sales_office')->onUpdate('cascade')->onDelete('cascade');
            $table->string('sales_group')->index()->nullable();
            $table->foreign('sales_group')->references('code')->on('tbl_master_customer_sales_group')->onUpdate('cascade')->onDelete('cascade');
            $table->string('sales_exe_code')->nullable();
            $table->string('br_number')->nullable();
            $table->string('vat_number')->nullable();
            $table->string('svat_number')->nullable();
            $table->string('credit_limit')->nullable();

            $table->enum('approval_status', ['Requested', 'Level1 Approved', 'Level2 Approved', 'Level3 Approved', 'Approved', 'Rejected'])->default('Requested');
            $table->string('reject_reason')->default('-');
            $table->string('date_time');

            //add two columns to current level and next level according to the workflow
            $table->string('current_level');
            $table->string('next_level');
            //add two columns to current level and next level according to the workflow

            $table->enum('sync_status', ['Yes', 'No'])->default('No');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('level2_approved_by')->nullable();
            $table->integer('level3_approved_by')->nullable();
            $table->integer('level4_approved_by')->nullable();
            $table->integer('level5_approved_by')->nullable();
            $table->text('history')->nullable();
            $table->string('name', 255)->nullable();
            $table->string('search_term', 255)->nullable();
            $table->integer('level1_approved_by')->nullable();

            $table->enum('request_type', ['Create', 'Update', 'Extend'])->default('Create');




            $table->timestamps();

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
