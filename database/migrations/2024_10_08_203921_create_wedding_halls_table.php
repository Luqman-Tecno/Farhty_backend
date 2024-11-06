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
            $table->foreignId('city_id')->constrained()->onDelete('cascade');
            $table->string('region')->nullable();
            $table->json('shift_prices')->nullable();
            $table->decimal('deposit_price', 10, 2)->nullable();
            $table->decimal('price_per_child', 8, 2)->nullable();
            $table->json('amenities')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('images')->nullable();
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);
            $table->softDeletes();
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
