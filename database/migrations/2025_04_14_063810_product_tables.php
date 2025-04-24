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
        // Create tb_product_cate_rela table
        Schema::create('product_cate_rela', function (Blueprint $table) {
            $table->id();  // Auto-incrementing id field
            $table->integer('product_id')->default(0);  // product_id field
            $table->integer('cate_id')->default(0);  // cate_id field

            $table->primary('id');  // Primary key
            $table->unique(['product_id', 'cate_id']);  // Unique constraint on (product_id, cate_id)
        });

        // Create tb_product_detail table
        Schema::create('product_detail', function (Blueprint $table) {
            $table->id();  // Auto-incrementing id field
            $table->integer('product_id')->default(0);  // product_id field
            $table->string('price', 10)->default('');  // price field
            $table->string('short_desc', 500)->default('');  // short_desc field
            $table->text('long_desc')->nullable();  // long_desc field

            $table->primary('id');  // Primary key
        });

        // Create tb_product_img table
        Schema::create('product_img', function (Blueprint $table) {
            $table->id();  // Auto-incrementing id field
            $table->integer('product_id')->default(0);  // product_id field
            $table->integer('attachment_id')->default(0);  // attachment_id field
            $table->tinyInteger('sort', false, true)->default(0);  // sort field
            $table->tinyInteger('is_main', false, true)->default(0);  // is_main field

            $table->primary('id');  // Primary key
        });

        // Create tb_product table
        Schema::create('product', function (Blueprint $table) {
            $table->id();  // Auto-incrementing id field
            $table->string('name', 120)->default('');  // name field
            $table->string('uri', 60)->default('');  // uri field

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
        // Drop tables in reverse order
        Schema::dropIfExists('product');
        Schema::dropIfExists('product_img');
        Schema::dropIfExists('product_detail');
        Schema::dropIfExists('product_cate_rela');
    }
};
