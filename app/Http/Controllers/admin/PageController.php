<?php

namespace App\Http\Controllers\admin;

use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Admin section
 */

class PageController extends Controller
{
	/**
	 * Get all page
	 */
	public function view(Request $request)
	{
		$page = Page::getAll()
			->when(true, function ($query) use ($request) {

				$orderType = $request->get('orderBy');

				if (!empty($orderType)) {
					/**
					 * Order By 
					 */
					switch ($orderType) {

						case 'lastUpdate':
							$query
								->where('updated_at', '>', now()->subDays(10)->endOfDay())
								->orderBy('updated_at', 'DESC');
							break;

						case 'name':
							$query->orderBy('name');
							break;

						case 'asc':
							$query->orderBy('id', 'ASC');
							break;

						case 'desc':
							$query->orderBy('id', 'DESC');
							break;

						default:
							$query->orderBy('id', 'DESC');
							break;
					}
				} else {
					$query->orderBy('id', 'DESC');
				}
			})
			->where(function ($query) use ($request) {

				$status = $request->get('status');

				if (!empty($status)) {
					$query->where('status', '=', $status);
				}
			})
			->paginate(25);

		$statistics = Page::statistics();

		return view('admin.views.page.index', compact('page', 'statistics'));
	}

	/**
	 * Get page modified template
	 * @return view
	 */
	public function modify($find)
	{
		if (!page::existSlugOrID($find)) {
			return redirect()->route('admin.page.index')
				->withErrors(['error' => 'The page doesn\'t exist']);
		}

		$page = Page::findBySlugOrID($find);

		return view('admin.views.page.modify', compact('page'));
	}
	/**
	 * Create / Edit page
	 */
	public function CreateOrEdit(Request $request)
	{
		/**
		 * Create first if is playload matched with "new"
		 */
		if ($request['slug'] === 'new') {
			return Page::CreatePage();
		}
		return $request;
	}
}
