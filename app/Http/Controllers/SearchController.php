<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Categories;
use Illuminate\Support\Str;
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

    /**
     * Handle search requests and return results with highlighted snippets.
     */
    public function index(Request $request)
    {
        $query = $request->input('query', '');

        $getTitle   = Post::where('title', 'like', "%{$query}%");
        $getSummary = Post::where('content', 'like', "%{$query}%");

        /**
         * Combine queries and paginate results
         */
        $results = $getTitle->union($getSummary)->paginate(10);

        // Highlight keywords in the results
        $results->getCollection()->transform(function ($result) use ($query) {
            $result->title   = $this->highlightTitle($result->title, $query);
            $result->content = $this->highlightKeywordSnippet($result->getContentText(), $query);
            return $result;
        });

        return view('public.search.index', [
            'results'  => $results,
            'query'    => $query,
            'category' => $this->getRandomCategories(),
        ]);
    }

    /**
     * Highlight the search query in the title.
     */
    private function highlightTitle($title, $query)
    {
        return preg_replace("/($query)/i", '<strong class="bg-yellow-200">$1</strong>', $title);
    }

    /**
     * Highlight the search query within a content snippet.
     */
    private function highlightKeywordSnippet($content, $keyword)
    {
        $keyword = preg_quote($keyword, '/');
        $content = strip_tags($content);


        $radius          = 300;
        $keywordPosition = stripos($content, $keyword);

        if ($keywordPosition === false) {
            return Str::limit($content, $radius * 2, '...');
        }

        $start   = max($keywordPosition - $radius, 0);
        $end     = min($keywordPosition + $radius + strlen($keyword), strlen($content));
        $snippet = substr($content, $start, $end - $start);

        return preg_replace("/($keyword)/i", '<strong class="bg-yellow-200">$1</strong>', $snippet);
    }

    /**
     * Retrieve random active categories.
     */
    private function getRandomCategories()
    {
        return Categories::where('is_active', true)
            ->inRandomOrder()
            ->limit(10)
            ->get();
    }
}