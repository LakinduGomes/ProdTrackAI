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
        Schema::create('tbl_master_plant', function (Blueprint $table) {
            $table->unsignedInteger('id', 11)->autoIncrement();
            $table->string('code',10)->unique()->index();
            $table->integer('status')->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        // Insert default material type
        DB::table('tbl_master_plant')->insert([
            [
                'code' => '2100',
                'status' => 1,
            ],
            [
                'code' => '2200',
                'status' => 1,
            ],
            [
                'code' => '2310',
                'status' => 1,
            ],
            [
                'code' => '2420',
                'status' => 1,
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_master_plant');
    }
};
