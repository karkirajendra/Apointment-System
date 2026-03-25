<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('sku')->nullable()->unique();

            // medicine/equipment
            $table->string('item_type')->default('medicine')->index();

            $table->unsignedInteger('stock_quantity')->default(0);
            $table->unsignedInteger('reorder_level')->default(0);

            $table->decimal('unit_cost', 10, 2)->default(0);

            $table->timestamps();
        });

        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('inventory_item_id')->index();

            // IN / OUT / ADJUST
            $table->string('movement_type')->index();

            // positive delta for IN/ADJUST, negative delta for OUT (stored as quantity_delta)
            $table->integer('quantity_delta')->default(0);

            $table->string('reason')->nullable();
            $table->timestamp('occurred_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
        Schema::dropIfExists('inventory_items');
    }
};

