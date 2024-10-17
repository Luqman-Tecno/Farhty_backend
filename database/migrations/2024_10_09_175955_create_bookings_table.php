<?php

use App\Models\User;
use App\Models\WeddingHall;
use App\Trait\EnumValues;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(WeddingHall::class);
            $table->date('booking_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('shift', \App\Enum\BookingShiftEnum::values());
            $table->decimal('deposit_cost', 10, 2);
            $table->decimal('total_cost', 10, 2);
            $table->boolean('deposit_paid')->default(false);
            $table->integer('children_count');
            $table->enum('status', \App\Enum\BookingStatusEnum::values());
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
