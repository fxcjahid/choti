<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Content extends Model
{
    use HasFactory;

    public $timestamps = false; // Disable update_at, create_at
    public $slug;
    public $service;
    public $instance;
    public $boilerContent;

    public function __construct(
        string $slug = null,
        string $service = null,
        array | string | object $boilerContent = null
    ) {
        $this->slug          = $slug;
        $this->service       = $service;
        $this->boilerContent = $boilerContent;

        $raw = collect($boilerContent);

        /**
         * Get instance data from DB
         */
        if (!empty($slug) && !empty($service)) {
            $this->instance();
            $this->getSet(
                $raw->keys()->toArray()
            );
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'city_slug',
        'service',
        'content',
    ];

    /**
     * Array loops
     */
    function array(array $array) {
        $contents = array();

        $collection = collect($array);

        $contents = $collection->map(function ($item, $key) {

            /**
             * Check if is string
             */
            if (
                is_string($item)
            ) {
                return $item;
            }

            /**
             * Determines if an array is a list.
             */
            if (
                Arr::isList($item)
            ) {
                return Arr::random($item);
            }

            /**
             * Determines if an array is associative.
             */
            if (
                Arr::isAssoc($item)
            ) {
                /**
                 * Order List blend
                 */

                if (in_array($key, ['orderList', 'step', 'item'])) {
                    $content = array();
                    foreach ($item as $key => $values) {

                        $content[$key] = Arr::random($values);
                    }
                    return $content;
                }

                /**
                 * Paragraph phrase
                 */
                if ($key == 'paragraph') {
                    $content = array();
                    foreach ($item as $key => $values) {

                        $content[$key] = Arr::random($values);
                    }
                    return implode(" ", $content);
                }
            }

            return Arr::isAssoc($item);
        });

        return $contents;
    }

    /**
     * Reactive data
     */
    public function getSet(array $value)
    {
        foreach ($value as $item) {
            $this->instance[$item] = $this->get($item) ?? $this->set($item);
        }
    }

    /**
     * Get column value
     * @return string
     */
    public function get(string $key)
    {
        return $this->instance[$key] ?? null;
    }

    /**
     * Update column value
     */
    public function set(string $key)
    {
        if (empty($this->boilerContent[$key])) {
            return;
        }

        /**
         * Check content exiting
         */
        if (
            $this->instance->only($key)->isEmpty()
        ) {

            $newContent[$key] = $this->array(
                $this->boilerContent[$key]
            );
        }

        /**
         * Check previous data exiting
         * if not empty then merge with new content
         */
        if (
            !$this->instance->isEmpty()
        ) {
            $content = $this->instance
                ->merge($newContent);
        } else {
            $content = $newContent;
        }

        /**
         * Update database or create
         */
        if (
            !$this->instance->isEmpty()
        ) {
            /**
             * Update
             */
            $response = tap(
                self::find(
                    $this->instance()->id
                ),
                function ($response) use ($content) {

                    $response->content = json_encode($content, true);
                    $response->save();
                }
            );

            return $content[$key]->toArray();

        } else {
            /**
             * Create new
             */

            $response = self::Create(
                [
                    'city_slug' => $this->slug,
                    'service'   => $this->service,
                    'content'   => json_encode($content),
                ]
            )->fresh();

            return $content[$key]->toArray();
        }
        return $content;
    }

    /**
     * get content data
     */
    public function instance()
    {
        $response = self::where([
            'service'   => $this->service,
            'city_slug' => $this->slug,
        ])
            ->where('content', '!=', null)
            ->first();

        $this->response = $response;

        $this->instance = collect(
            json_decode($response->content ?? null, true)
        );

        return $response;
    }

}
