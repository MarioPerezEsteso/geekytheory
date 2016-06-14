<?php

namespace App\Http\Controllers;

use App\Category;
use App\Repositories\CategoryRepository;
use App\Repositories\PostRepository;
use App\Validators\CategoryValidator;
use File;
use Illuminate\Http\Request;
use App\Http\Requests;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Validator;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    /**
     * Number of tags to show with pagination
     */
    const TAGS_PAGINATION_NUMBER = 10;

    /**
     * @var CategoryRepository
     */
    protected $repository;

    /**
     * Validator for Category creation and update.
     *
     * @var CategoryValidator
     */
    protected $validator;

    /**
     * CategoryController constructor.
     *
     * @param CategoryRepository $categoryRepository
     * @param CategoryValidator $categoryValidator
     */
    public function __construct(CategoryRepository $categoryRepository, CategoryValidator $categoryValidator)
    {
        $this->repository = $categoryRepository;
        $this->validator = $categoryValidator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->repository->paginate(self::TAGS_PAGINATION_NUMBER);
        return view('home.posts.categories', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->repository->paginate(self::TAGS_PAGINATION_NUMBER);
        return view('home.posts.categories', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (empty($request->slug) && !empty($request->category)) {
            $slug = $this->getAvailableSlug($request->category);
        } else {
            $slug = $this->getAvailableSlug($request->slug);
        }

        $data = array(
            'category' => $request->category,
            'slug' => $slug,
            'image' => $request->file('image')
        );

        if (!$this->validator->with($data)->passes()) {
            return Redirect::to('home/categories')->withErrors($this->validator->errors());
        } else {
            $category = new Category;
            $category->category = $request->category;
            $category->slug = $slug;
            if ($data['image']) {
                $fileName = ImageManagerController::getImageName($data['image'], ImageManagerController::PATH_IMAGE_UPLOADS);
                $category->image = $fileName;
                $data['image']->move(ImageManagerController::PATH_IMAGE_UPLOADS, $fileName);
            }
            $category->save();
        }

        return Redirect::to('home/categories')->withSuccess(trans('home.category_create_success'));

    }

    /**
     * Display list of posts by category.
     *
     * @param string $categorySlug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showByCategory($categorySlug)
    {
        $category = $this->repository->findCategoryBySlug($categorySlug);
        $posts = (new PostRepository())->findPostsByCategory($category);
        return view('themes.' . IndexController::THEME . '.categoryposts', compact('posts', 'category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // TODO
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // TODO
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // TODO
    }

    public function getAvailableSlug($text)
    {
        $slugAvailable = false;
        $slugSuffix = "";
        $counter = 1;
        while (!$slugAvailable) {
            $slug = slugify($text . $slugSuffix);
            if (Category::where('slug', $slug)->first() == null) {
                $slugAvailable = true;
            }
            $slugSuffix = "-" . $counter++;
        }
        return $slug;
    }
}
