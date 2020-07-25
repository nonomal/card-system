<?php
namespace App\Mail; use Illuminate\Bus\Queueable; use Illuminate\Mail\Mailable; use Illuminate\Queue\SerializesModels; use Illuminate\Contracts\Queue\ShouldQueue; class ProductCountWarn extends Mailable { use Queueable, SerializesModels; public $product = null; public $product_count = null; public function __construct($sp648779, $spd62313) { $this->product = $sp648779; $this->product_count = $spd62313; } public function build() { return $this->subject('您的商品库存不足-' . config('app.name'))->view('emails.product_count_warn'); } }