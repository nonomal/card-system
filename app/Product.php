<?php
namespace App; use App\Library\Helper; use Illuminate\Database\Eloquent\Model; class Product extends Model { protected $guarded = array(); protected $hidden = array(); const ID_API = -1001; const DELIVERY_AUTO = 0; const DELIVERY_MANUAL = 1; function getUrlAttribute() { return config('app.url') . '/p/' . Helper::id_encode($this->id, Helper::ID_TYPE_PRODUCT); } function getCountAttribute() { return $this->count_all - $this->count_sold; } function category() { return $this->belongsTo(Category::class); } function cards() { return $this->hasMany(Card::class); } function coupons() { return $this->hasMany(Coupon::class); } function orders() { return $this->hasMany(Order::class); } function user() { return $this->belongsTo(User::class); } public static function refreshCount($spdc0e57) { \App\Card::where('user_id', $spdc0e57->id)->selectRaw('`product_id`,SUM(`count_sold`) as `count_sold`,SUM(`count_all`) as `count_all`')->groupBy('product_id')->orderByRaw('`product_id`')->chunk(1000, function ($spa237bd) { foreach ($spa237bd as $sp32442e) { $sp73d110 = \App\Product::where('id', $sp32442e->product_id)->first(); if ($sp73d110->delivery === \App\Product::DELIVERY_AUTO) { $sp73d110->update(array('count_sold' => $sp32442e->count_sold, 'count_all' => $sp32442e->count_all)); } else { $sp73d110->update(array('count_sold' => $sp32442e->count_sold)); } } }); } function setForShop($spdc0e57 = null) { $sp73d110 = $this; $spe71595 = $sp73d110->count; $sp66254c = $sp73d110->inventory; if ($sp66254c == User::INVENTORY_AUTO) { $sp66254c = System::_getInt('shop_inventory'); } if ($sp66254c == User::INVENTORY_RANGE) { if ($spe71595 <= 0) { $sp40af45 = '不足'; } elseif ($spe71595 <= 10) { $sp40af45 = '少量'; } elseif ($spe71595 <= 20) { $sp40af45 = '一般'; } else { $sp40af45 = '大量'; } $sp73d110->setAttribute('count2', $sp40af45); } else { $sp73d110->setAttribute('count2', $spe71595); } $sp73d110->setAttribute('count', $spe71595); $sp73d110->setVisible(array('id', 'name', 'description', 'fields', 'delivery', 'count', 'count2', 'buy_min', 'buy_max', 'support_coupon', 'password_open', 'price', 'price_whole')); } }