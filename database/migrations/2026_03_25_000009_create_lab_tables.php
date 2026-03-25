<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lab_tests', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('patient_id')->index();
            $table->unsignedBigInteger('doctor_id')->index();

            $table->unsignedBigInteger('booking_id')->nullable()->index();

            $table->string('test_name');
            $table->string('status')->default('Ordered')->index(); // Ordered / InProgress / Completed

            $table->timestamp('ordered_at')->nullable();

            $table->timestamps();
        });

        Schema::create('lab_results', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('lab_test_id')->index();

            $table->text('result_value')->nullable();
            $table->string('normal_range')->nullable();

            // Lab attachments (pdf/image) stored via Storage disk.
            $table->string('attachment_path')->nullable();

            $table->timestamp('result_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lab_results');
        Schema::dropIfExists('lab_tests');
    }
};

