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
        // Create tb_menu_item table
        Schema::create('menu_item', function (Blueprint $table) {
            $table->id();  // Auto-incrementing id field
            $table->string('name', 60)->default('');  // name field
            $table->string('url', 800)->default('');  // url field

            $table->integer('created_by')->default(0);  // created_by field
            $table->timestamps(0);  // created_at and updated_at timestamps

            $table->integer('updated_by')->default(0);  // updated_by field
        });

        // Create tb_menu table
        Schema::create('menu', function (Blueprint $table) {
            $table->id();  // Auto-incrementing id field
            $table->string('name', 60)->default('');  // name field
            $table->text('menu')->nullable();  // menu field (text type)

            $table->integer('created_by')->default(0);  // created_by field
            $table->timestamps(0);  // created_at and updated_at timestamps

            $table->integer('updated_by')->default(0);  // updated_by field

            $table->unique('name');  // Unique constraint on name
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the tables in reverse order
        Schema::dropIfExists('menu');
        Schema::dropIfExists('menu_item');
    }
};
