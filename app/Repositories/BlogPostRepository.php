<?php

namespace App\Repositories;

use App\Models\BlogPost as Model;

/**
 *Class BlogCategoryRepository
 *
 *@package App\Reposotories
 */


class BlogPostRepository extends CoreRepository
{
    /**
     *@return string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     *get list posts to display
     * (Admin)
     */
    public function getAllWithPaginator()
    {
        $colums = [
            'id',
            'title',
            'slug',
            'is_published',
            'published_at',
            'user_id',
            'category_id'
        ];

        $result = $this->startConditions()
                        ->select($colums)
                        ->orderBy('id', 'DESC')
                        ->with(['user:id,name',
                            'category:id,title'])
                        ->paginate(25);


        return $result;
    }

    public function getEdit($id)
    {
        return$this->startConditions()->find($id);
    }
}
