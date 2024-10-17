<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wedding_halls', function (Blueprint $table) {
            $table->id();
            $table->string('hall_name');
            $table->integer('capacity')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->foreignIdFor(\App\Models\City::class);
            $table->string('region')->nullable();
            $table->json('shift_prices')->nullable();
            $table->decimal('deposit_price', 8, 2)->nullable();
            $table->decimal('price_per_child', 8, 2)->nullable();
            $table->text('amenities')->nullable();
            $table->foreignIdFor(\App\Models\User::class)->onDelete('cascade');
            $table->json('images')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wedding_halls');
    }
};
