<?php
namespace App\Library\Geetest; class Lib { const GT_SDK_VERSION = 'php_3.2.0'; public static $connectTimeout = 1; public static $socketTimeout = 1; private $response; public $captcha_id; public $private_key; public function __construct($spbe4e72, $sp784eba) { $this->captcha_id = $spbe4e72; $this->private_key = $sp784eba; } public function pre_process($spf36aa8 = null) { $spedbcde = 'http://api.geetest.com/register.php?gt=' . $this->captcha_id; if ($spf36aa8 != null and is_string($spf36aa8)) { $spedbcde = $spedbcde . '&user_id=' . $spf36aa8; } $spbd7ba2 = $this->send_request($spedbcde); if (strlen($spbd7ba2) != 32) { $this->failback_process(); return 0; } $this->success_process($spbd7ba2); return 1; } private function success_process($spbd7ba2) { $spbd7ba2 = md5($spbd7ba2 . $this->private_key); $sp8b1f25 = array('success' => 1, 'gt' => $this->captcha_id, 'challenge' => $spbd7ba2); $this->response = $sp8b1f25; } private function failback_process() { $sp268279 = md5(rand(0, 100)); $sp795dc1 = md5(rand(0, 100)); $spbd7ba2 = $sp268279 . substr($sp795dc1, 0, 2); $sp8b1f25 = array('success' => 0, 'gt' => $this->captcha_id, 'challenge' => $spbd7ba2); $this->response = $sp8b1f25; } public function get_response_str() { return json_encode($this->response); } public function get_response() { return $this->response; } public function success_validate($spbd7ba2, $spdcf238, $sp7aabf6, $spf36aa8 = null) { if (!$this->check_validate($spbd7ba2, $spdcf238)) { return 0; } $sp7da4d7 = array('seccode' => $sp7aabf6, 'sdk' => self::GT_SDK_VERSION); if ($spf36aa8 != null and is_string($spf36aa8)) { $sp7da4d7['user_id'] = $spf36aa8; } $spedbcde = 'http://api.geetest.com/validate.php'; $sp4f72ad = $this->post_request($spedbcde, $sp7da4d7); if ($sp4f72ad == md5($sp7aabf6)) { return 1; } else { if ($sp4f72ad == 'false') { return 0; } else { return 0; } } } public function fail_validate($spbd7ba2, $spdcf238, $sp7aabf6) { if ($spdcf238) { $sp739a14 = explode('_', $spdcf238); try { $sp3eb542 = $this->decode_response($spbd7ba2, $sp739a14['0']); $sp8f3d4d = $this->decode_response($spbd7ba2, $sp739a14['1']); $sp1567df = $this->decode_response($spbd7ba2, $sp739a14['2']); $spab6380 = $this->get_failback_pic_ans($sp8f3d4d, $sp1567df); $sp14bace = abs($sp3eb542 - $spab6380); } catch (\Exception $spa356ee) { return 1; } if ($sp14bace < 4) { return 1; } else { return 0; } } else { return 0; } } private function check_validate($spbd7ba2, $spdcf238) { if (strlen($spdcf238) != 32) { return false; } if (md5($this->private_key . 'geetest' . $spbd7ba2) != $spdcf238) { return false; } return true; } private function send_request($spedbcde) { if (function_exists('curl_exec')) { $spbfabb9 = curl_init(); curl_setopt($spbfabb9, CURLOPT_URL, $spedbcde); curl_setopt($spbfabb9, CURLOPT_CONNECTTIMEOUT, self::$connectTimeout); curl_setopt($spbfabb9, CURLOPT_TIMEOUT, self::$socketTimeout); curl_setopt($spbfabb9, CURLOPT_RETURNTRANSFER, 1); $sp7da4d7 = curl_exec($spbfabb9); if (curl_errno($spbfabb9)) { $spa47a7c = sprintf('curl[%s] error[%s]', $spedbcde, curl_errno($spbfabb9) . ':' . curl_error($spbfabb9)); $this->triggerError($spa47a7c); } curl_close($spbfabb9); } else { $sp7b0194 = array('http' => array('method' => 'GET', 'timeout' => self::$connectTimeout + self::$socketTimeout)); $sp337d0a = stream_context_create($sp7b0194); $sp7da4d7 = file_get_contents($spedbcde, false, $sp337d0a); } return $sp7da4d7; } private function post_request($spedbcde, $sp839cd2 = '') { if (!$sp839cd2) { return false; } $sp7da4d7 = http_build_query($sp839cd2); if (function_exists('curl_exec')) { $spbfabb9 = curl_init(); curl_setopt($spbfabb9, CURLOPT_URL, $spedbcde); curl_setopt($spbfabb9, CURLOPT_RETURNTRANSFER, 1); curl_setopt($spbfabb9, CURLOPT_CONNECTTIMEOUT, self::$connectTimeout); curl_setopt($spbfabb9, CURLOPT_TIMEOUT, self::$socketTimeout); if (!$sp839cd2) { curl_setopt($spbfabb9, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); } else { curl_setopt($spbfabb9, CURLOPT_POST, 1); curl_setopt($spbfabb9, CURLOPT_POSTFIELDS, $sp7da4d7); } $sp7da4d7 = curl_exec($spbfabb9); if (curl_errno($spbfabb9)) { $spa47a7c = sprintf('curl[%s] error[%s]', $spedbcde, curl_errno($spbfabb9) . ':' . curl_error($spbfabb9)); $this->triggerError($spa47a7c); } curl_close($spbfabb9); } else { if ($sp839cd2) { $sp7b0194 = array('http' => array('method' => 'POST', 'header' => 'Content-type: application/x-www-form-urlencoded
' . 'Content-Length: ' . strlen($sp7da4d7) . '
', 'content' => $sp7da4d7, 'timeout' => self::$connectTimeout + self::$socketTimeout)); $sp337d0a = stream_context_create($sp7b0194); $sp7da4d7 = file_get_contents($spedbcde, false, $sp337d0a); } } return $sp7da4d7; } private function decode_response($spbd7ba2, $spc526f8) { if (strlen($spc526f8) > 100) { return 0; } $spa32dd2 = array(); $sp80fac9 = array(); $sp35a365 = array('0' => 1, '1' => 2, '2' => 5, '3' => 10, '4' => 50); $spb37164 = 0; $sp46b569 = 0; $spc83c93 = str_split($spbd7ba2); $sp8bb203 = str_split($spc526f8); for ($sp133c87 = 0; $sp133c87 < strlen($spbd7ba2); $sp133c87++) { $sp286f69 = $spc83c93[$sp133c87]; if (in_array($sp286f69, $sp80fac9)) { continue; } else { $sp739a14 = $sp35a365[$spb37164 % 5]; array_push($sp80fac9, $sp286f69); $spb37164++; $spa32dd2[$sp286f69] = $sp739a14; } } for ($sp7967f4 = 0; $sp7967f4 < strlen($spc526f8); $sp7967f4++) { $sp46b569 += $spa32dd2[$sp8bb203[$sp7967f4]]; } $sp46b569 = $sp46b569 - $this->decodeRandBase($spbd7ba2); return $sp46b569; } private function get_x_pos_from_str($spd2d955) { if (strlen($spd2d955) != 5) { return 0; } $sp5372b9 = 0; $sp9ed4bf = 200; $sp5372b9 = base_convert($spd2d955, 16, 10); $sp8b1f25 = $sp5372b9 % $sp9ed4bf; $sp8b1f25 = $sp8b1f25 < 40 ? 40 : $sp8b1f25; return $sp8b1f25; } private function get_failback_pic_ans($sp636837, $spe9ba58) { $sp6b521d = substr(md5($sp636837), 0, 9); $sp84ea64 = substr(md5($spe9ba58), 10, 9); $sp06feda = ''; for ($sp133c87 = 0; $sp133c87 < 9; $sp133c87++) { if ($sp133c87 % 2 == 0) { $sp06feda = $sp06feda . $sp6b521d[$sp133c87]; } elseif ($sp133c87 % 2 == 1) { $sp06feda = $sp06feda . $sp84ea64[$sp133c87]; } } $sp5b5673 = substr($sp06feda, 4, 5); $spab6380 = $this->get_x_pos_from_str($sp5b5673); return $spab6380; } private function decodeRandBase($spbd7ba2) { $sp0f65f4 = substr($spbd7ba2, 32, 2); $sp98a1e0 = array(); for ($sp133c87 = 0; $sp133c87 < strlen($sp0f65f4); $sp133c87++) { $spf3070c = ord($sp0f65f4[$sp133c87]); $sp8b1f25 = $spf3070c > 57 ? $spf3070c - 87 : $spf3070c - 48; array_push($sp98a1e0, $sp8b1f25); } $sp37c8af = $sp98a1e0['0'] * 36 + $sp98a1e0['1']; return $sp37c8af; } private function triggerError($spa47a7c) { } }