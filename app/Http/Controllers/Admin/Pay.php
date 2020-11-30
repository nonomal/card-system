<?php
namespace App\Http\Controllers\Admin; use App\Library\Helper; use Carbon\Carbon; use function foo\func; use Illuminate\Http\Request; use App\Http\Controllers\Controller; use App\Library\Response; class Pay extends Controller { function get(Request $sp179c14) { $sp78fbd3 = \App\Pay::orderBy('sort'); $sp2cc7da = $sp179c14->post('enabled'); if (strlen($sp2cc7da)) { $sp78fbd3->whereIn('enabled', explode(',', $sp2cc7da)); } $sp2ae16a = $sp179c14->post('search', false); $sp2fe7b9 = $sp179c14->post('val', false); if ($sp2ae16a && $sp2fe7b9) { if ($sp2ae16a == 'simple') { return Response::success($sp78fbd3->get(array('id', 'name'))); } elseif ($sp2ae16a == 'id') { $sp78fbd3->where('id', $sp2fe7b9); } else { $sp78fbd3->where($sp2ae16a, 'like', '%' . $sp2fe7b9 . '%'); } } $spe11c26 = $sp78fbd3->get(); return Response::success(array('list' => $spe11c26, 'urls' => array('url' => config('app.url'), 'url_api' => config('app.url_api')))); } function stat(Request $sp179c14) { $this->validate($sp179c14, array('day' => 'required|integer|between:1,30')); $sp09db71 = (int) $sp179c14->input('day'); if ($sp09db71 === 30) { $sp56db69 = Carbon::now()->addMonths(-1); } else { $sp56db69 = Carbon::now()->addDays(-$sp09db71); } $spe11c26 = $this->authQuery($sp179c14, \App\Order::class)->where(function ($sp78fbd3) { $sp78fbd3->where('status', \App\Order::STATUS_PAID)->orWhere('status', \App\Order::STATUS_SUCCESS); })->where('paid_at', '>=', $sp56db69)->with(array('pay' => function ($sp78fbd3) { $sp78fbd3->select(array('id', 'name')); }))->groupBy('pay_id')->selectRaw('`pay_id`,COUNT(*) as "count",SUM(`paid`) as "sum"')->get()->toArray(); $spa6aab5 = array(); foreach ($spe11c26 as $sp286f69) { if (isset($sp286f69['pay']) && isset($sp286f69['pay']['name'])) { $sp320118 = $sp286f69['pay']['name']; } else { $sp320118 = '未知方式#' . $sp286f69['pay_id']; } $spa6aab5[$sp320118] = array((int) $sp286f69['count'], (int) $sp286f69['sum']); } return Response::success($spa6aab5); } function edit(Request $sp179c14) { $this->validate($sp179c14, array('id' => 'required|integer', 'name' => 'required|string', 'img' => 'required|string', 'driver' => 'required|string', 'way' => 'required|string', 'config' => 'required|string')); $spadc22c = (int) $sp179c14->post('id'); $spf9ff9c = $sp179c14->post('name'); $sp9a4f3e = $sp179c14->post('img'); $sp3e66e6 = $sp179c14->post('comment'); $sp1de99d = $sp179c14->post('driver'); $sp5dc631 = $sp179c14->post('way'); $sp42ccac = $sp179c14->post('config'); $sp2cc7da = (int) $sp179c14->post('enabled'); $sp1596b5 = \App\Pay::find($spadc22c); if (!$sp1596b5) { $sp1596b5 = new \App\Pay(); } $sp1596b5->name = $spf9ff9c; $sp1596b5->img = $sp9a4f3e; $sp1596b5->comment = $sp3e66e6; $sp1596b5->driver = $sp1de99d; $sp1596b5->way = $sp5dc631; $sp1596b5->config = $sp42ccac; $sp1596b5->enabled = $sp2cc7da; $sp1596b5->fee_system = $sp179c14->post('fee_system'); $sp1596b5->saveOrFail(); return Response::success(); } function comment(Request $sp179c14) { $this->validate($sp179c14, array('id' => 'required|integer')); $spadc22c = (int) $sp179c14->post('id'); $sp1596b5 = \App\Pay::findOrFail($spadc22c); $sp1596b5->comment = $sp179c14->post('comment'); $sp1596b5->save(); return Response::success(); } function sort(Request $sp179c14) { $this->validate($sp179c14, array('id' => 'required|integer')); $spadc22c = (int) $sp179c14->post('id'); $sp1596b5 = \App\Pay::findOrFail($spadc22c); $sp1596b5->sort = (int) $sp179c14->post('sort', 1000); $sp1596b5->save(); return Response::success(); } function fee_system(Request $sp179c14) { $this->validate($sp179c14, array('id' => 'required|integer')); $spadc22c = (int) $sp179c14->post('id'); $sp1596b5 = \App\Pay::findOrFail($spadc22c); $sp1596b5->fee_system = $sp179c14->post('fee_system'); $sp1596b5->saveOrFail(); return Response::success(); } function enable(Request $sp179c14) { $this->validate($sp179c14, array('ids' => 'required|string', 'enabled' => 'required|integer|between:0,3')); $sp786967 = $sp179c14->post('ids'); $sp2cc7da = (int) $sp179c14->post('enabled'); \App\Pay::whereIn('id', explode(',', $sp786967))->update(array('enabled' => $sp2cc7da)); return Response::success(); } function delete(Request $sp179c14) { $this->validate($sp179c14, array('id' => 'required|integer')); $spadc22c = (int) $sp179c14->post('id'); \App\Pay::whereId($spadc22c)->delete(); return Response::success(); } }