<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();

            // Link to patient (customers) and appointment (bookings).
            $table->unsignedBigInteger('patient_id')->index();
            $table->unsignedBigInteger('booking_id')->nullable()->index();

            $table->decimal('total_amount', 10, 2)->default(0);

            // Optional insurance info.
            $table->string('insurance_provider')->nullable();
            $table->string('insurance_number')->nullable();

            // Unpaid / Paid / PartiallyPaid (kept as string for SQLite compatibility)
            $table->string('status')->default('Unpaid')->index();

            $table->timestamp('issued_at')->nullable();
            $table->timestamp('due_at')->nullable();

            $table->timestamps();
        });

        Schema::create('bill_payments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('bill_id')->index();
            $table->decimal('amount', 10, 2)->default(0);
            $table->string('payment_method')->nullable(); // cash, card, insurance, etc.

            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bill_payments');
        Schema::dropIfExists('bills');
    }
};

