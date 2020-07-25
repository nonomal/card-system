<?php
namespace App\Http\Controllers\Merchant; use App\Library\Helper; use App\Library\Response; use App\System; use Illuminate\Http\Request; use App\Http\Controllers\Controller; class Category extends Controller { function get(Request $sp054aa0) { $sp1d90fd = $sp054aa0->post('current_page', 1); $sp21d879 = $sp054aa0->post('per_page', 20); $sp0964e2 = $this->authQuery($sp054aa0, \App\Category::class); $spcb6e4b = $sp054aa0->post('search', false); $spe07b43 = $sp054aa0->post('val', false); if ($spcb6e4b && $spe07b43) { if ($spcb6e4b == 'simple') { return Response::success($sp0964e2->get(array('id', 'name'))); } elseif ($spcb6e4b == 'id') { $sp0964e2->where('id', $spe07b43); } else { $sp0964e2->where($spcb6e4b, 'like', '%' . $spe07b43 . '%'); } } $spc0281b = $sp054aa0->post('enabled'); if (strlen($spc0281b)) { $sp0964e2->whereIn('enabled', explode(',', $spc0281b)); } $sp03b529 = $sp0964e2->withCount('products')->orderBy('sort')->paginate($sp21d879, array('*'), 'page', $sp1d90fd); foreach ($sp03b529->items() as $sp4a59d6) { $sp4a59d6->setAppends(array('url')); } return Response::success($sp03b529); } function sort(Request $sp054aa0) { $this->validate($sp054aa0, array('id' => 'required|integer')); $sp4a59d6 = $this->authQuery($sp054aa0, \App\Category::class)->findOrFail($sp054aa0->post('id')); $sp4a59d6->sort = (int) $sp054aa0->post('sort', 1000); $sp4a59d6->save(); return Response::success(); } function edit(Request $sp054aa0) { $this->validate($sp054aa0, array('name' => 'required|string|max:128')); $sp71416b = $sp054aa0->post('name'); $spc0281b = (int) $sp054aa0->post('enabled'); $spa194d8 = $sp054aa0->post('sort'); $spa194d8 = $spa194d8 === NULL ? 1000 : (int) $spa194d8; if (System::_getInt('filter_words_open') === 1) { $sp5d277b = explode('|', System::_get('filter_words')); if (($sp93ae8e = Helper::filterWords($sp71416b, $sp5d277b)) !== false) { return Response::fail('提交失败! 分类名称包含敏感词: ' . $sp93ae8e); } } if ($spa194d8 < 0 || $spa194d8 > 1000000) { return Response::fail('排序需要在0-1000000之间'); } $spec6cbf = $sp054aa0->post('password'); $spbaf635 = $sp054aa0->post('password_open') === 'true'; if ((int) $sp054aa0->post('id')) { $sp4a59d6 = $this->authQuery($sp054aa0, \App\Category::class)->findOrFail($sp054aa0->post('id')); } else { $sp4a59d6 = new \App\Category(); $sp4a59d6->user_id = $this->getUserIdOrFail($sp054aa0); } $sp4a59d6->name = $sp71416b; $sp4a59d6->sort = $spa194d8; $sp4a59d6->password = $spec6cbf; $sp4a59d6->password_open = $spbaf635; $sp4a59d6->enabled = $spc0281b; $sp4a59d6->saveOrFail(); return Response::success(); } function enable(Request $sp054aa0) { $this->validate($sp054aa0, array('ids' => 'required|string', 'enabled' => 'required|integer|between:0,1')); $sp4f46fd = $sp054aa0->post('ids', ''); $spc0281b = (int) $sp054aa0->post('enabled'); $this->authQuery($sp054aa0, \App\Category::class)->whereIn('id', explode(',', $sp4f46fd))->update(array('enabled' => $spc0281b)); return Response::success(); } function delete(Request $sp054aa0) { $this->validate($sp054aa0, array('ids' => 'required|string')); $sp4f46fd = $sp054aa0->post('ids', ''); $this->authQuery($sp054aa0, \App\Category::class)->whereIn('id', explode(',', $sp4f46fd))->delete(); return Response::success(); } }