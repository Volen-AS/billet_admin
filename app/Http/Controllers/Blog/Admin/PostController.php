<?php

namespace App\Http\Controllers\Blog\Admin;

use App\Models\BlogPost;
use App\Repositories\BlogCategoryRepository;
use App\Repositories\BlogPostRepository;
use App\Http\Requests\BlogPostUpdateRequest;
use App\Http\Requests\BlogPostCreateRequest;

/**
  *post management
  * @package App\Http\Controller\Blog\Admin
  */

class PostController extends BaseController
{
    /**
     * @var BlogPostRepository
     */
    private $blogPostRepository;

    /**
     *@var BlogCategoryRepository
     */
    private $blogCategoryRepository;
    /**
     *Post controller constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->blogPostRepository = app(BlogPostRepository::class);
        $this->blogCategoryRepository = app(BlogCategoryRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = $this->blogPostRepository->getAllWithPaginator();
        //dd($paginator);

        return view('blog.admin.posts.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $item = new BlogPost();
        $categoryList = $this->blogCategoryRepository->getForComboBox();

        return view('blog.admin.posts.edit',
                compact('item', 'categoryList'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BlogPostCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogPostCreateRequest $request)
    {
        $data = $request->input();
        $item = (new BlogPost())->create($data);

        if($item) {
            return redirect()->route('blog.admin.posts.edit', [$item->id])
                                ->with(['success' => 'saved successfully'] );
        } else {
            return back()->withErrors(['msg' => 'Errors save post'])
                            ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = $this->blogPostRepository->getEdit($id);
        if(empty($item)) {
            abort(404);
        }
        $categoryList = $this->blogCategoryRepository->getForComboBox();


        return view('blog.admin.posts.edit',
            compact('item','categoryList'));
    }

    /**
     * Update the specified resource in storage.
     * @param  BlogPostUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogPostUpdateRequest $request, $id)
    {
        $item = $this->blogPostRepository->getEdit($id);

        if(empty($item)) {
            return back()
                ->withErrors(['msg' => 'Post id=[{$id}] not founded'])
                ->withInput();
        }
        $data = $request->all();

        $result = $item->update($data);

        if ($result) {
            return redirect()
                ->route('blog.admin.posts.edit', $item->id)
                ->with(['success' => 'post saved']);
        } else {
            return back()
                ->withErrors(['msg' => 'Error save'])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $result = BlogPost::destroy($id);

       if ($result) {
           return redirect()
               ->route('blog.admin.posts.index')
               ->with(['success' => "Article id[$id] was deleted"]);
       } else {
           return back()->withErrors(['msg' => 'Error delete']);
       }
    }
}
