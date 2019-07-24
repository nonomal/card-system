<?php
use Illuminate\Support\Facades\Schema; use Illuminate\Database\Schema\Blueprint; use Illuminate\Database\Migrations\Migration; class CreateOrdersTable extends Migration { public function up() { Schema::create('orders', function (Blueprint $sp3c6e67) { $sp3c6e67->increments('id'); $sp3c6e67->integer('user_id')->index(); $sp3c6e67->string('order_no', 128)->index(); $sp3c6e67->integer('product_id'); $sp3c6e67->string('product_name')->nullable(); $sp3c6e67->integer('count'); $sp3c6e67->string('ip')->nullable(); $sp3c6e67->string('customer', 32)->nullable(); $sp3c6e67->string('contact')->nullable(); $sp3c6e67->text('contact_ext')->nullable(); $sp3c6e67->tinyInteger('send_status')->default(App\Order::SEND_STATUS_UN); $sp3c6e67->text('remark')->nullable(); $sp3c6e67->integer('cost')->default(0); $sp3c6e67->integer('price')->default(0); $sp3c6e67->integer('discount')->default(0); $sp3c6e67->integer('paid')->default(0); $sp3c6e67->integer('fee')->default(0); $sp3c6e67->integer('system_fee')->default(0); $sp3c6e67->integer('income')->default(0); $sp3c6e67->integer('pay_id'); $sp3c6e67->string('pay_trade_no')->nullable(); $sp3c6e67->integer('status')->default(\App\Order::STATUS_UNPAY); $sp3c6e67->string('frozen_reason')->nullable(); $sp3c6e67->string('api_out_no', 128)->nullable(); $sp3c6e67->text('api_info')->nullable(); $sp3c6e67->dateTime('paid_at')->nullable(); $sp3c6e67->timestamps(); }); } public function down() { Schema::dropIfExists('orders'); } }