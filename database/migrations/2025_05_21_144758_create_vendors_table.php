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
        Schema::create('vendors', function (Blueprint $table) {
        $table->id('vendor_id');
        $table->enum('request_type',['Create','Update','Extend'])->default('Create');
        $table->string('email')->unique();
        $table->string('vendor_type')->nullable();
        $table->string('business_name');
        $table->string('business_registration_number')->nullable();
        $table->string('sales_person')->nullable();
        $table->string('business_tax_reg_no')->nullable();
        $table->string('nic_passport_no')->nullable();
        $table->string('tax_status')->nullable();
        $table->string('tax_number')->nullable();
        $table->string('w_h_tax_status')->nullable();
        $table->string('w_h_tax_number')->nullable();
        $table->string('mobile_no')->nullable();
        $table->string('telephone_1')->nullable();
        $table->string('telephone_2')->nullable();
        $table->string('fax_no')->nullable();
        $table->string('house_no')->nullable();
        $table->string('address_line_1')->nullable();
        $table->string('address_line_2')->nullable();
        $table->string('address_line_3')->nullable();
        $table->string('postal_code')->nullable();
        $table->unsignedBigInteger('city')->index();
        $table->foreign('city')->references('id')->on('tbl_master_vendor_city')->onUpdate('cascade')->onDelete('cascade');
        $table->unsignedBigInteger('district')->index();
        $table->foreign('district')->references('id')->on('tbl_master_vendor_district')->onUpdate('cascade')->onDelete('cascade');
        $table->unsignedBigInteger('region')->index();
        $table->foreign('region')->references('id')->on('tbl_master_vendor_region')->onUpdate('cascade')->onDelete('cascade');
        $table->string('block_function')->nullable();
        $table->foreign('block_function')->references('code')->on('tbl_master_vendor_block_functions')->onUpdate('cascade')->onDelete('cascade');
        $table->string('currency')->index();
        $table->foreign('currency')->references('code')->on('tbl_master_vendor_currency')->onUpdate('cascade')->onDelete('cascade');
        $table->enum('block_status',['Yes','No'])->default('No')->nullable();
        $table->string('reason')->nullable();
        $table->string('country')->nullable();
        $table->string('beneficiary_bank_name')->nullable();
        $table->string('account_owner_name')->nullable();
        $table->string('bank_branch_name')->nullable();
        $table->string('bank_branch_code')->nullable();
        $table->string('bank_city')->nullable();
        $table->string('bank_acc_no')->nullable();
        $table->string('alternate_payee_name')->nullable();
        $table->string('search_term')->nullable();
        $table->string('payment_term')->nullable();
        $table->string('company_profile_path')->nullable();
        $table->string('business_registration_nic_or_passport_path')->nullable();
        $table->string('vat_tax_registration_gst_certificate_path')->nullable();
        $table->string('bank_confirmation_statement_letter_path')->nullable();
        $table->string('company_standard_quality_certificates_path')->nullable();
        $table->string('self_declaration_vendor_path')->nullable();
        $table->string('declare_status')->nullable();
        
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
        $table->text('history')->nullable();
        $table->enum('approval_status', [
            'Requested',
            'Level1 Approved',
            'Level2 Approved',
            'Level3 Approved',
            'Approved',
            'Rejected'
        ])->default('Requested');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
