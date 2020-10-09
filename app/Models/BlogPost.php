<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 *Class BlogPOsts
 *
 * @package App\Models
 *
 * @property \App\Models\BlogCategory $category
 * @property \App\Models\User         $user
 * @property string $title
 * @property string $slug
 * @property string $category_id
 * @property string $excerpt
 * @property string $content_raw
 * @property string $published_at
 * property boolean $is_published
 */

class BlogPost extends Model
{
        use SoftDeletes;

        const UNKNOWN_USER = 1;

        protected $fillable
            = [
                'title',
                'slug',
                'category_id',
                'excerpt',
                'content_raw',
                'is_published',
                'published_at',

            ];

        /**
         *category of blog
         *@return \Illuminate\Database\Eloquent\Relations\BelongsTo
         */
        public function category()
        {
            //the article belongs to the category
            return $this->belongsTo(BlogCategory::class);
        }
        /**
         *Autor of article
         */
        public function user()
        {
            //The article belongs to the user
            return $this->belongsTo(User::class);
        }
}

