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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->string('customer_email')->index();
            $table->string('customer_phone_number')->nullable();
            $table->foreignId('health_professional_id')->constrained('health_professionals');
            $table->foreignId('service_id')->constrained('services');
            $table->timestamp('start_date_time');
            $table->timestamp('end_date_time')->nullable();
            $table->boolean('confirmed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
