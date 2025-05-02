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
        // Create tb_role table
        Schema::create('roles', function (Blueprint $table) {
            $table->id();  // Auto-incrementing id field
            $table->string('name', 60)->default('');  // name field
            $table->integer('added_by')->default(0);  // added_by field
            $table->timestamp('added_date')->nullable();  // added_date field
            $table->integer('updated_by')->default(0);  // updated_by field
            $table->timestamp('updated_date')->nullable();  // updated_date field

            $table->primary('id');  // Primary key on id
            $table->unique('name');  // Unique constraint on name
        });

        // Insert initial data into tb_role
        DB::table('roles')->insert([
            ['name' => 'administrator', 'created_at' => '2023-07-05 12:12:12'],
            ['name' => 'customer', 'created_at' => '2023-07-05 12:12:12'],
        ]);

        // Create tb_user_role table
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();  // Auto-incrementing id field
            $table->integer('user_id')->default(0);  // user_id field
            $table->integer('role_id')->default(0);  // role_id field

            $table->integer('created_by')->default(0);  // created_by field
            $table->timestamp('created_at')->nullable();  // created_at timestamp
            $table->integer('updated_by')->default(0);  // updated_by field
            $table->timestamp('updated_at')->nullable();  // updated_at timestamp

            $table->primary('id');  // Primary key on id
            $table->unique(['user_id', 'role_id']);  // Unique constraint on (user_id, role_id)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the tables in reverse order
        Schema::dropIfExists('user_roles');
        Schema::dropIfExists('roles');
    }
};
