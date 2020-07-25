<?php
use Illuminate\Support\Facades\Schema; use Illuminate\Database\Schema\Blueprint; use Illuminate\Database\Migrations\Migration; class CreatePaysTable extends Migration { public function up() { Schema::create('pays', function (Blueprint $sp232d91) { $sp232d91->increments('id'); $sp232d91->string('name'); $sp232d91->integer('sort')->default(1000); $sp232d91->string('img'); $sp232d91->string('driver'); $sp232d91->string('way'); $sp232d91->text('config'); $sp232d91->text('comment')->nullable(); $sp232d91->float('fee_system', 8, 4)->default(0.01); $sp232d91->boolean('enabled'); $sp232d91->timestamps(); }); } public function down() { Schema::dropIfExists('pays'); } }