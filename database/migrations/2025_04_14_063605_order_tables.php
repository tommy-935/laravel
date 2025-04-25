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
        // Create tb_order_price table
        Schema::create('order_price', function (Blueprint $table) {
            $table->id();  // Auto-incrementing id field
            $table->integer('order_id')->default(0);  // order_id field
            $table->string('discount_price', 6)->default('');  // discount_price field
            $table->string('sub_total', 6)->default('');  // total_price field
            $table->string('total', 6)->default('');  // total_price field
            $table->string('tax', 6)->default('');  // total_price field

            $table->primary('id');  // Primary key
        });

        // Create tb_order_product table
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();  // Auto-incrementing id field
            $table->integer('order_id')->default(0);  // order_id field
            $table->integer('product_id')->default(0);  // product_id field
            $table->string('product_name', 120)->default('');  // product_name field
            $table->string('price', 6)->default('');  // price field
            $table->integer('qty')->default(0);  // qty field
            $table->string('item_price', 6)->default('');  // item_price field

            $table->primary('id');  // Primary key
        });

        // Create tb_order_user table
        Schema::create('order_user', function (Blueprint $table) {
            $table->id();  // Auto-incrementing id field
            $table->integer('order_id')->default(0);  // order_id field
            $table->integer('user_id')->default(0);  // user_id field
            $table->string('session_id', 60)->default('');  // session_id field
            $table->string('billing_country', 60)->default('');  // country field
            $table->string('billing_state', 25)->default('');  // state field
            $table->string('billing_city', 25)->default('');  // city field
            $table->string('billing_first_name', 25)->default('');  // first_name field
            $table->string('billing_last_name', 25)->default('');  // last_name field
            $table->string('billing_email', 60)->default('');  // email field
            $table->string('billing_address', 255)->default('');  // address field
            $table->string('billing_phone', 25)->default('');  // phone field
            $table->string('billing_zip_code', 25)->default('');  // phone field

            $table->string('shipping_country', 60)->default('');  // country field
            $table->string('shipping_state', 25)->default('');  // state field
            $table->string('shipping_city', 25)->default('');  // city field
            $table->string('shipping_first_name', 25)->default('');  // first_name field
            $table->string('shipping_last_name', 25)->default('');  // last_name field
            $table->string('shipping_email', 60)->default('');  // email field
            $table->string('shipping_address', 255)->default('');  // address field
            $table->string('shipping_phone', 25)->default('');  // phone field
            $table->string('shipping_zip_code', 25)->default('');  // phone field

            $table->primary('id');  // Primary key
        });

        // Create tb_order table
        Schema::create('order', function (Blueprint $table) {
            $table->id();  // Auto-incrementing id field
            $table->string('order_num', 25)->default('');  // order_num field
            $table->string('order_key', 32)->default('');  // order_num field

            $table->string('status', 12)->default('');  // order_status field

            $table->integer('created_by')->default(0);  // created_by field
            $table->timestamps(0);  // created_at and updated_at timestamps

            $table->integer('updated_by')->default(0);  // updated_by field
        });

        // Create tb_order_payment table
        Schema::create('order_payment', function (Blueprint $table) {
            $table->id();  // Auto-incrementing id field
            $table->integer('order_id')->default(0);  // order_id field
            $table->string('order_num', 25)->default('');  // order_num field
            $table->dateTime('paid_date')->nullable();  // paid_date field
            $table->string('payment_method', 12)->default('')->comment('wechatpay | alipay | paypal | stripe');  // payment_method field
            $table->tinyInteger('status', false, true)->default(0)->comment('payment status');  // status field
            $table->string('amount', 6)->default('');  // amount field
            $table->string('currency', 6)->default('USD');  // currency field
            $table->string('transaction_id', 25)->default('');  // transaction_id field
            $table->text('details')->nullable()->default(null);

            $table->integer('created_by')->default(0);  // created_by field
            $table->timestamps(0);  // created_at and updated_at timestamps

            $table->integer('updated_by')->default(0);  // updated_by field
        });

        Schema::create('soft_token', function (Blueprint $table) {
            $table->id();  // Auto-incrementing id field
            $table->integer('order_id')->default(0);  // order_id field
            $table->integer('user_id')->default(0);
            $table->string('email', 25)->default('');  // order_num field
            $table->string('token', 32)->default('');  
            $table->string('soft_name', 25)->default('');  // amount field
            $table->integer('website_num')->default(0);
            $table->dateTime('expired_at')->nullable();

            $table->integer('created_by')->default(0);  // created_by field
            $table->timestamps(0);  // created_at and updated_at timestamps

            $table->integer('updated_by')->default(0);  // updated_by field
        });

        Schema::create('soft_token_active', function (Blueprint $table) {
            $table->id();  // Auto-incrementing id field
            $table->integer('soft_token_id')->default(0);  // order_id field
            $table->string('website', 25)->default('');  // order_num field
            $table->string('user_agent', 255)->default('');  
            $table->string('ip', 32)->default('');  // amount field
            $table->dateTime('actived_at')->nullable();

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
        Schema::dropIfExists('order_payment');
        Schema::dropIfExists('order');
        Schema::dropIfExists('order_user');
        Schema::dropIfExists('order_product');
        Schema::dropIfExists('order_price');
        Schema::dropIfExists('soft_token');
        Schema::dropIfExists('soft_token_active');
    }
};
