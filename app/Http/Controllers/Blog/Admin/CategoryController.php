<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Models\BlogCategory;
use App\Http\Requests\BlogCategoryUpdateRequest;
use App\Http\Requests\BlogCategoryCreateRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use App\Repositories\BlogCategoryRepository;
use Illuminate\View\View;
use \Illuminate\Http\RedirectResponse;


class CategoryController extends BaseController
{
    /**
     * @var BlogCategoryRepository
     */
    private $blogCategoryRepository;

    function __construct()
    {
        parent::__construct();

        $this->blogCategoryRepository = app(BlogCategoryRepository::class);
    }

    /**
     * Display a listing of the resource.
     * @return Application|Factory|Response|View
     *
     */
    public function index()
    {
        $paginator = $this->blogCategoryRepository->getAllWithPaginator(25);

        return view('blog.admin.categories.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {
        $item = new BlogCategory();
        $categoryList
            = $this->blogCategoryRepository->getForComboBox() ;

        return view('blog.admin.categories.edit',
                compact('item', 'categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BlogCategoryCreateRequest $request
     * @return RedirectResponse
     */
    public function store(BlogCategoryCreateRequest $request)
    {
        $data = $request->input();

        $item = (new BlogCategory())->create($data);

        if($item) {
            return redirect()->route('blog.admin.categories.edit', [$item->id])
                ->with(['success' => 'Saved down']);
        }else {
            return back()->withErrors(['msg' => 'Error to save'])
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|Response|View
     */
    public function edit($id)
    {
        $item = $this->blogCategoryRepository->getEdit($id);
        if(empty($item)) {
            abort(404);
        }

        $categoryList = $this->blogCategoryRepository
            ->getForComboBox();


        return view('blog.admin.categories.edit',
            compact('item', 'categoryList'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  BlogCategoryUpdateRequest  $request
     * @param  int  $id
     * @return RedirectResponse|Response
     */
    public function update(BlogCategoryUpdateRequest $request, $id)
    {
        $item = $this->blogCategoryRepository->getEdit($id);

        if(empty($item)) {
            return back()
                ->withErrors(['msg' => "record id=[[$id]]not found"])
                ->withInput();
        }
        $data = $request->all();
        if(empty($data['slug'])){
            $data['slug'] = Str::slug($data['title']);
        }
        $result = $item->update($data);

        if($result){
            return redirect()
                ->route('blog.admin.categories.edit', $item->id)
                ->with(['success' => 'successful saved']);
        }else {
            return back()
                ->withErrors(['msg' => 'Save error'])
                ->withInput();
        }

    }

}
