<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();

            // `customers` table is your current Patient source.
            $table->unsignedBigInteger('patient_id')->index();

            $table->string('title');
            $table->text('description')->nullable();

            // Single file for simplicity (reports, scans, etc).
            $table->string('file_path')->nullable();

            // Track who uploaded the record (doctor/staff later). Nullable for backward compatibility.
            $table->unsignedBigInteger('uploaded_by_employee_id')->nullable()->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};

