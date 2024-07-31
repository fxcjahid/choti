<?php

namespace App\Models;

use App\Traits\Relationship;
use App\Traits\Scope;
use App\Traits\Sluggable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use fxcjahid\LaravelEditorJsHtml\BlocksManager;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Post extends Model
{
    use HasFactory, Sluggable, Scope, Relationship, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'name',
        'content',
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {

            $post->content = self::setContent($post->content);

            // Set Article Status
            if (empty($post->status)) {
                $post->status = 'draft';
            }
        });
    }

    private static function setContent($content)
    {
        if (empty($content)) {
            return json_encode([
                'time'    => round(microtime(true) * 1000),
                'blocks'  => [],
                'version' => '2.27.0',
            ], JSON_PRETTY_PRINT);
        } else {
            if (! isValidEditorJsBlocks($content)) {
                return ConvertPlaneTextToEditorJsBlocks($content);
            }
        }

        return $content;
    }

    /**
     * Replace post content to HTML view useing Block-editor
     * Wrap content by views
     */
    public function getContent()
    {
        $blocksManager = new BlocksManager($this->content);

        return $blocksManager->renderHtml();
    }

    /**
     * Get Post content only Text Format
     * @return string 
     */
    public function getContentText()
    {
        $blocksManager = new BlocksManager($this->content);

        return $blocksManager->renderText();
    }

    /**
     * Generate post url
     * @return string
     */
    public function url()
    {
        $category = ! empty($this->category[0]->slug) ? $this->category[0]->slug : 'draft';

        return route('post.show', [$category, $this->slug]);
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
     * Modifed Summary if is empty
     * Fillup Summary from body
     */
    public function getSummaryAttribute()
    {
        $contentText = $this->getContentText();
        $summary     = Str::words($contentText, 400, '');

        return ! empty($this->summary) ? $this->summary : $summary;
    }

    public function getAuthorAttribute()
    {
        if ($this->user && $this->user->name()) {
            $name = $this->user->name();
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
    public static function findPublishPost($category, $post)
    {
        return self::WithThumbnail()
            ->WithSeries()
            ->WithTag()
            ->WithComments()
            ->WherePublished()
            ->WhereCategory($category)
            ->whereSlug($post)
            ->firstOrFail();
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
        $draft      = self::where('status', '=', 'draft')->count('status');
        $trash      = self::where('status', '=', 'trash')->count('status');
        $scheduled  = self::where('status', '=', 'scheduled')->count('status');
        $lastUpdate = self::where('updated_at', '>', now()->subDays(10)->endOfDay())->count('id');

        return (object) array(
            'all'        => $all,
            'publish'    => $publish,
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
}