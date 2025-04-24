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
        Schema::create('cate_rela', function (Blueprint $table) {
            $table->id();  // Auto-incrementing id field
            $table->integer('cate_id')->default(0);  // cate_id field
            $table->integer('parent_id')->default(0);  // parent_id field
            
            // Composite unique key for cate_id and parent_id
            $table->unique(['cate_id', 'parent_id']);

            $table->primary('id');  // Primary key
        });

        Schema::create('cate', function (Blueprint $table) {
            $table->id();  // Auto-incrementing id field
            $table->string('cate_name', 60)->default('');  // cate_name field
            $table->string('slug', 60)->default('');  // slug field
            $table->string('img_uri', 60)->default('');  // img_uri field
            $table->string('desc', 800)->default('');  // desc field

            $table->integer('created_by')->default(0);  // created_by field
            $table->timestamps(0);  // created_at and updated_at timestamps

            $table->integer('updated_by')->default(0);  // updated_by field
            
            // Unique index on slug field
            $table->unique('slug');

            $table->primary('id');  // Primary key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cate_rela');
        Schema::dropIfExists('cate');
    }
};
