<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 *Class BlogCategory
 * @package App\Models
 *
 * @property-read BlogCategory $parentCategory
 * @property-read string $parentTitle
 */
class BlogCategory extends Model
{
         use SoftDeletes;

        /**
         * Root Category id
         * @var int
         */
         const ROOT = 1;

         protected $fillable
            = [
               'title',
               'slug',
               'parent_id',
               'description'
             ];

        /**
         *Get parent category
         */
         public function parentCategory()
         {
             return $this->belongsTo(BlogCategory::class,'parent_id','id');
         }

         /**
          *laravel accessor
          * @return string
          */
         public function getParentTitleAttribute()
         {
             $title = $this->parentCategory->title
                 ?? ($this->isRoot()
                    ? 'RootCategory'
                    : '???');

             return $title;
         }

         /**
          *is the current element a root
          * @return bool
          */
         public function isRoot()
         {
             return $this->id === BlogCategory::ROOT;
         }








}
