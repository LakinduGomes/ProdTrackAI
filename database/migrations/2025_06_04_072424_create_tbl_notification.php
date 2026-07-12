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
        Schema::create('tbl_notification', function (Blueprint $table) {
                $table->id(); // Primary key (auto-increment)
                $table->unsignedBigInteger('user_id'); // Foreign key (assumes users table)
                $table->text('notification'); // Notification message
                $table->string('approval_status')->nullable(); // Nullable approval status
                $table->string('link'); // Link related to the notification
                $table->boolean('is_read')->default(false);
                $table->timestamps(); //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_notification');
    }
};
