<?php
use Illuminate\Support\Facades\Schema; use Illuminate\Database\Schema\Blueprint; use Illuminate\Database\Migrations\Migration; class CreateShopThemesTable extends Migration { public function up() { Schema::create('shop_themes', function (Blueprint $sp232d91) { $sp232d91->increments('id'); $sp232d91->string('name', 128)->unique(); $sp232d91->string('description')->nullable(); $sp232d91->text('options')->nullable(); $sp232d91->text('config')->nullable(); $sp232d91->boolean('enabled')->default(true); }); \App\ShopTheme::freshList(); } public function down() { Schema::dropIfExists('shop_themes'); } }