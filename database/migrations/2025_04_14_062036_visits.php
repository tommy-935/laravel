<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id(); // int auto_increment primary key
            $table->string('session_id', 255)->default('');
            $table->string('ip', 255)->default('');
            $table->string('user_agent', 1000)->default('');
            $table->string('url', 1000)->default('');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();

            $table->unique(['session_id', DB::raw('url(191)')], 'sess_url');
        });

        Schema::create('email_logs', function (Blueprint $table) {
            $table->id(); // int auto_increment primary key
            $table->string('email', 255)->default('');
            $table->string('ip', 255)->default('');
            $table->string('user_agent', 1000)->default('');
            $table->string('subject', 512)->default('');
            $table->text('body')->nullable()->default(null);
            $table->tinyInteger('status', false, true)->default(1)->comment('0: waitting, 1: success');  // status field
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->integer('created_by')->default(0);  // created_by field

            $table->integer('updated_by')->default(0);  // updated_by field
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
        Schema::dropIfExists('email_logs');
    }
};
