<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('offer_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wedding_hall_id')->constrained()->onDelete('cascade');
            $table->decimal('sale_price', 10, 2);
            $table->boolean('status')->default(false);
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->decimal('discount_percentage', 5, 2)->nullable();
            $table->text('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offer_sales');
    }
};
