<?php
namespace App\Http\Controllers\Shop; use App\Library\Response; use App\Library\Geetest; use Illuminate\Http\Request; use App\Http\Controllers\Controller; class VerifyCode extends Controller { function getVerify() { $spf81742 = array('driver' => 'geetest', 'geetest' => Geetest\API::get()); return Response::success($spf81742); } }