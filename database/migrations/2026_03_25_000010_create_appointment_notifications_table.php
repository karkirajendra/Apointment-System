<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointment_notifications', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('booking_id')->index();

            // e.g. created, rescheduled, cancelled, status_changed
            $table->string('type')->index();

            $table->text('message');

            $table->timestamp('read_at')->nullable()->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointment_notifications');
    }
};

