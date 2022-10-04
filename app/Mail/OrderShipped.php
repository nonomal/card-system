<?php
namespace App\Mail; use Illuminate\Bus\Queueable; use Illuminate\Mail\Mailable; use Illuminate\Queue\SerializesModels; use Illuminate\Contracts\Queue\ShouldQueue; class OrderShipped extends Mailable { use Queueable, SerializesModels; public $tries = 3; public $timeout = 20; public $order_no; public $order_url; public $card_msg; public $cards_txt; public function __construct($spaf5db5, $spfc43e7, $sp8ca25c) { $this->order_no = $spaf5db5->order_no; $this->order_url = config('app.url') . route('pay.result', array($spaf5db5->order_no), false); $this->card_msg = $spfc43e7; $this->cards_txt = $sp8ca25c; } public function build() { return $this->subject('订单提醒(#' . $this->order_no . ')-' . config('app.name'))->view('emails.order'); } }