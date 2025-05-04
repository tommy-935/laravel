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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();  // Auto-incrementing id field
            $table->string('session_id', 125)->default('');  // session_id field
            $table->integer('user_id')->default(0);  // user_id field
            $table->string('item_key', 125)->default('');

            $table->integer('product_id')->default(0);  // product_id field
            $table->integer('quantity')->default(0);  // quantity field
            $table->dateTime('expired_date')->nullable();  // expired_date field

            $table->integer('created_by')->default(0);  // created_by field
            $table->timestamps(0);  // created_at and updated_at timestamps

            $table->integer('updated_by')->default(0);  // updated_by field
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
