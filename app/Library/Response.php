<?php
namespace App\Library; class Response { public static function json($spdcb2c5 = array(), $sp646c5e = 200, array $sp9e3fb1 = array(), $sp08c573 = 0) { return response()->json($spdcb2c5, $sp646c5e, $sp9e3fb1, $sp08c573); } public static function success($spdcb2c5 = array()) { return self::json(array('message' => 'success', 'data' => $spdcb2c5)); } public static function fail($spe765e4 = 'fail', $spdcb2c5 = array()) { return self::json(array('message' => $spe765e4, 'data' => $spdcb2c5), 500); } public static function forbidden($spe765e4 = 'forbidden', $spdcb2c5 = array()) { return self::json(array('message' => $spe765e4, 'data' => $spdcb2c5), 403); } }