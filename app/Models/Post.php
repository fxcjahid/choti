<?php

namespace App\Models;

use App\Traits\Scope;
use App\Traits\Sluggable;
use Illuminate\Support\Str;
use App\Traits\Relationship;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use CyrildeWit\EloquentViewable\Support\Period;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Post extends Model implements Viewable
{
    use HasFactory, Sluggable, Scope, Relationship, InteractsWithViews, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'name',
        'email',
        'content',
        'summary',
        'user_id',
        'status', // 'publish','draft','scheduled','trash'
    ];

    protected $cats = [
        'thumbnail' => 'array',
    ];

    /**
     * The attribute that will be slugged.
     *
     * @var string
     */
    protected $slugAttribute = 'title';

    /**
     * Remove views on delete
     * To automatically delete all views of an viewable Eloquent model on delete.
     *
     * @see https://github.com/cyrildewit/eloquent-viewable?tab=readme-ov-file#remove-views-on-delete
     * @var boolean
     */
    protected $removeViewsOnDelete = true;


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {

            if (auth()->check()) {
                $post->user_id = auth()->id();
            }

            // Set Article Status
            if (empty($post->status)) {
                $post->status = 'pendding';
            }
        });
    }

    /**
     * Generate post url
     * @return string
     */
    public function url()
    {
        // Direct request parameters take precedence
        $requestType = request()->category ?? request()->series ?? request()->tag;
        if ($requestType) {
            return route('post.show', [$requestType, $this->slug]);
        }

        $type = request()->type;
        $url  = collect([
            $this->category()->where('slug', $type)->value('slug'),
            $this->series()->where('slug', $type)->value('slug'),
            $this->tag()->where('slug', $type)->value('slug'),
        ])->filter()->first() ?? $this->category[0]->slug ?? 'draft';

        return route('post.show', [$url, $this->slug]);
    }

    /**
     * Get post thumbnail image
     * @param string $size
     */
    public function image($size = null)
    {
        $image = ! empty(isset($this->thumbnail[0]->medium))
            ? $this->thumbnail[0]->medium
            : null;

        return $image;
    }

    /**
     * Summary of getSummaryAttribute
     * @param string $value
     * @return string $summary
     */
    public function getSummaryAttribute($value)
    {
        return $value ?: Str::words($this->content, 400, '');
    }

    public function getAuthorAttribute()
    {
        if ($this->user && $this->user->name) {
            $name = $this->user->name;
        }

        return $name ?? $this->name ?? 'unknown';
    }

    public function previous()
    {
        return self::where('created_at', '<', $this->created_at)
            ->orderByDesc('created_at')
            ->first();
    }

    public function next()
    {
        return self::where('created_at', '>', $this->created_at)
            ->orderBy('created_at')
            ->first();
    }

    /**
     * Get publish aricles link for Sitemap
     */
    public static function sitemap()
    {
        return self::where('status', '=', 'publish')
            ->with([
                'category' => function ($query) {
                    $query->select([
                        'id',
                        'slug',
                    ]);
                }
            ])
            ->get([
                'id',
                'slug',
                'updated_at',
            ])
            ->makeHidden([
                'user_id',
                'summary',
                'status',
                'readTime',
                'pivot',
                'content',
                'created_at',
                'deleted_at',
                'body',
            ])
            ->map(function ($each) {
                return [
                    'url'     => route('post.show', [
                        'slug'     => $each->slug,
                        'category' => $each->category[0]['slug'],
                    ]),
                    'lastmod' => $each->updated_at,
                ];
            });
    }

    /**
     * Checking exiting Slug or ID
     */
    public static function existSlugOrID($ID)
    {
        return self::where('id', $ID)
            ->orWhere('slug', $ID)->exists();
    }

    /**
     * Create New Post
     */
    public static function CreatePost()
    {
        return self::Create(
            [
                'user_id' => auth()->id(),
            ],
        )->fresh();
    }

    /**
     * Find exiting post By Slug Or ID
     */
    public static function findBySlugOrID($find)
    {
        return self::with([
            'user',
            'tag',
            'category',
            'series',
            'thumbnail',
            'comments',
        ])->where('slug', $find)
            ->orWhere('id', $find)
            ->firstOrFail();
    }

    /**
     * Get all post
     * @return mixed
     */
    public static function getAll()
    {
        return self::with([
            'user',
            'tag',
            'category',
            'thumbnail',
        ]);
    }

    /**
     * Get active post by slug
     * @return mixed
     **/
    public static function findPublishPost($type, $slug)
    {
        $query = self::WithThumbnail()
            ->WithSeries()
            ->WithTag()
            ->WithComments()
            ->WherePublished()
            ->whereSlug($slug);

        $post = $query->where(function ($q) use ($type) {
            $q->WhereCategory($type);
        })->first();

        if (! $post) {
            $post = $query->where(function ($q) use ($type) {
                $q->WhereSeries($type);
            })->first();
        }

        if (! $post) {
            $post = $query->where(function ($q) use ($type) {
                $q->WhereTag($type);
            })->first();
        }

        return $post ?? abort(404);
    }

    /**
     * Count post statistics
     * @var all
     * @var publish
     * @var draft
     * @var scheduled
     * @var trash
     * @return mixed
     */
    public static function statistics()
    {
        $all        = self::count('status');
        $publish    = self::where('status', '=', 'publish')->count('status');
        $pendding   = self::where('status', '=', 'pendding')->count('status');
        $draft      = self::where('status', '=', 'draft')->count('status');
        $trash      = self::where('status', '=', 'trash')->count('status');
        $scheduled  = self::where('status', '=', 'scheduled')->count('status');
        $lastUpdate = self::where('updated_at', '>', now()->subDays(10)->endOfDay())->count('id');

        return (object) array(
            'all'        => $all,
            'publish'    => $publish,
            'pendding'   => $pendding,
            'draft'      => $draft,
            'trash'      => $trash,
            'scheduled'  => $scheduled,
            'lastUpdate' => $lastUpdate,
        );
    }

    /**
     * Get suggestion post base on category & title
     * Relation between table
     * @return mixed
     */
    public function suggestion()
    {
        return self::where(function ($query) {

            $query->whereHas('category', function ($query) {
                $query->whereIn('name', $this->category->pluck('name'));
            })

                ->orWhereHas('tag', function ($query) {
                    $query->whereIn('name', $this->tag->pluck('name'));
                })

                ->orWhereHas('series', function ($query) {
                    $query->whereIn('name', $this->series->pluck('name'));
                });

        })
            ->where('id', '!=', $this->id) // So you won't fetch same post
            ->WherePublished()
            ->take(6)
            ->get();
    }

    /**
     * Get related post by category wise
     * Relation between table
     * @return mixed
     */
    public function related()
    {
        return self::whereHas('category', function ($query) {
            return $query->whereIn('name', $this->category->pluck('name'));
        })
            ->where('id', '!=', $this->id) // So you won't fetch same post
            ->where('status', '=', 'publish')
            ->take(6)
            ->with([
                'thumbnail',
            ])
            ->get();
    }


    /**
     * Get top view post by weekend
     * @param mixed $query
     * @param mixed $limit
     * @return mixed
     */
    public function scopeTopViewed($query, $limit = 30)
    {
        return $query->orderByViews('desc', Period::pastWeeks(1))
            ->where('status', '=', 'publish')
            ->take($limit);
    }
}
