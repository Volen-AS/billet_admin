<?php

use Illuminate\Database\Seeder;

class BlogCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [];
        $cName = 'Not categories';
        $categories[] = [
            'title' => $cName,
            'slug' => Str::slug($cName),
            'parent_id' => 0,
        ];

        for($i = 2; $i <= 11; $i++ ) {
            $cName = 'Category #' .$i;
            $parentId = ($i >4) ? rand(1,4) : 1;

            $categories[] = [
                'title' => $cName,
                'slug' => Str::slug($cName),
                'parent_id' => $parentId,
            ];
        }
        DB::table('blog_categories')->insert($categories);
    }
}
