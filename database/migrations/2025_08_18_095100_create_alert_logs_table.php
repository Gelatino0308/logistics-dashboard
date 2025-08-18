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
        Schema::create('alert_logs', function (Blueprint $table) {
            $table->id();
            $table->decimal('delivery_lat', 10, 7);
            $table->decimal('delivery_lon', 10, 7);
            $table->enum('alert_radius', [100, 250, 500])->default(250);
            $table->decimal('distance', 8, 2);
            $table->boolean('is_within_range?');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alert_logs');
    }
};
