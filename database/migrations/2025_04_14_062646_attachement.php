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
        Schema::create('attachment', function (Blueprint $table) {
            $table->id();  // Auto-incrementing id field
            $table->string('name', 120)->default('');  // Name field, default is empty string
            $table->string('uri', 255);  // URI field
            $table->string('type', 10)->default('image')->comment('image/pdf/doc...');  // Type field with default value and comment

            $table->integer('created_by')->default(0);  // Created by field
            $table->integer('updated_by')->default(0);  // Updated by field

            $table->timestamps(0);  // created_at and updated_at timestamp fields (0 precision)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachment');
    }
};
