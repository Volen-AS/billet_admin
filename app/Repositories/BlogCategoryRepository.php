<?php

namespace App\Repositories;

use App\Models\BlogCategory as Model;
use Illuminate\Database\Eloquent\Collection;

/**
 *Class BlogCategoryRepository
 *
 *@package App\Reposotories
 */
class BlogCategoryRepository extends CoreRepository
{

    /**
     *get model for edit in admin panel
     *
     * @param int $id
     *
     * @return Model
     */
    public function getEdit(int $id)
    {
        return $this->startConditions()->find($id);
    }

    /**
     *get array categories for category list
     *
     *@return Collection
     */
    public function getForComboBox()
    {

        $colums = implode(',', [
           'id',
           'CONCAT (id, ". ", title) AS id_title'
        ]);

        $result = $this->startConditions()
            ->selectRaw($colums)
            ->toBase()
            ->get();

        return $result;

    }

    /**
     *@return string
     */

    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     *get category with paginator
     * @param int/null $perPage
     * @return void
     */
    public function getAllWithPaginator($perPage =null)
    {
        $colums = ['id', 'title', 'parent_id'];

        $result = $this
            ->startConditions()
            ->select($colums)
            ->with([
                'parentCategory:id,title'
            ])
            ->paginate($perPage);

        return $result;
    }



}
