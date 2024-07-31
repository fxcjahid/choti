<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Traits\HasCrudActions;

class SearchController extends Controller
{
    use HasCrudActions;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'search.search';

    /**
     * Route prefix.
     *
     * @var string
     */
    protected $routePrefix = 'search';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $viewPath = 'public.search';

    public function index(Request $request)
    {
        $query = $request->input('query');

        $results = Post::where('title', 'like', "%{$query}%")
            // ->orWhere('content', 'like', "%{$query}%")
            ->paginate(10);

        $category = Categories::where('is_active', '=', true)
            ->inRandomOrder()
            ->limit(10)
            ->get();

        return view('public.search.index', compact('results', 'query', 'category'));
    }

}