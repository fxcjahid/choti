<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\SoftDeletes;

trait Sluggable
{
    /**
     * Boot the trait.
     *
     * @return void
     */
    public static function bootSluggable()
    {
        static::creating(function ($entity) {
            $entity->setSlug();
        });
    }

    /**
     * Set the slug attribute.
     *
     * @param string $value
     * @return void
     */
    public function setSlug($value = null)
    {
        if (is_null($value)) {
            $value = $this->getAttribute($this->slugAttribute);
        }

        $this->slug = $this->generateSlug($value);
    }

    /**
     * Generate slug by the given value.
     *
     * @param string $value
     * @return string
     */
    private function generateSlug($value)
    {
        $slug = $this->slugify($value);

        $query = $this->getModel()->where('slug', $slug);

        if (in_array(SoftDeletes::class, class_uses($this->getModel()))) {
            $query = $query->withTrashed();
        }

        if ($query->exists()) {
            $slug .= '-' . rand(2, 50);
        }

        return $slug;
    }

    private function slugify($value)
    {
        $slug = preg_replace('/[\s<>[\]{}|\\^%&\$,\/:~!`;=?@#\'\"]/', '-', mb_strtolower($value));

        // Remove duplicate separators.
        $slug = preg_replace('/-+/', '-', $slug);

        // Trim special characters from the beginning and end of the slug.
        return trim($slug, '!"#$%&\'()*+,-./:;<=>?@[]^_`{|}~');
    }
}