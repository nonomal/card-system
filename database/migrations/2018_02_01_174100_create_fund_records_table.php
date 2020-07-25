<?php
use Illuminate\Support\Facades\Schema; use Illuminate\Database\Schema\Blueprint; use Illuminate\Database\Migrations\Migration; class CreateFundRecordsTable extends Migration { public function up() { Schema::create('fund_records', function (Blueprint $sp232d91) { $sp232d91->increments('id'); $sp232d91->integer('user_id')->index(); $sp232d91->integer('type')->default(\App\FundRecord::TYPE_OUT); $sp232d91->integer('amount'); $sp232d91->integer('balance')->default(0); $sp232d91->integer('order_id')->nullable(); $sp232d91->string('withdraw_id')->nullable(); $sp232d91->string('remark')->nullable(); $sp232d91->timestamps(); }); DB::unprepared('ALTER TABLE `fund_records` CHANGE COLUMN `created_at` `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP;'); } public function down() { Schema::dropIfExists('fund_records'); } }