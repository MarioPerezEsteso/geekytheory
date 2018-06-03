<?php

namespace App\Http\Controllers;

use App\Article;
use App\Category;
use App\Validators\CategoryValidator;
use File;
use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    /**
     * Number of tags to show with pagination
     */
    const TAGS_PAGINATION_NUMBER = 10;

    /**
     * Validator for Category creation and update.
     *
     * @var CategoryValidator
     */
    protected $validator;

    /**
     * CategoryController constructor.
     *
     * @param CategoryValidator $categoryValidator
     */
    public function __construct(CategoryValidator $categoryValidator)
    {
        $this->validator = $categoryValidator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(self::TAGS_PAGINATION_NUMBER);
        return view('home.posts.categories', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::paginate(self::TAGS_PAGINATION_NUMBER);
        return view('home.posts.categories', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
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
            'description' => $request->description,
            'slug' => $slug,
            'image' => $request->file('image'),
        );

        if (!$this->validator->with($data)->passes()) {
            return Redirect::to('home/categories')->withErrors($this->validator->errors());
        } else {

            if ($data['image']) {
                $fileName = ImageManagerController::getUploadFilename($data['image']);
                $data['image']->move(ImageManagerController::getPathYearMonth(), $fileName);
                $data['image'] = ImageManagerController::getPathYearMonth() . $fileName;
            }

            Category::create($data);
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
        $category = Category::getBySlug($categorySlug);
        $articles = Article::getByCategory($category)->with('user', 'categories')->paginate(10);

        return view('web.blog.postlist.index', compact('articles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::paginate(self::TAGS_PAGINATION_NUMBER);

        return view('home.posts.categories', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $data = array(
            'category' => $request->category,
            'description' => $request->description,
            'slug' => $request->slug,
            'image' => $request->file('image'),
        );

        if (!$this->validator->update($id)->with($data)->passes()) {
            return Redirect::to("home/categories/edit/$id")->withErrors($this->validator->errors());
        } else {
            if ($data['image']) {
                $fileName = ImageManagerController::getUploadFilename($data['image']);
                $data['image']->move(ImageManagerController::getPathYearMonth(), $fileName);
                $data['image'] = ImageManagerController::getPathYearMonth() . $fileName;
            }
            $category->update($id, $data);
        }

        return Redirect::to('home/categories')->withSuccess(trans('home.category_update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->destroy($id);

        return Redirect::to('home/categories')->withSuccess(trans('home.category_delete_success'));
    }

    /**
     * Delete the image of a category.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function deleteImage(Request $request)
    {
        if (!empty($request->id)) {
            $category = Category::findOrFail($request->id);
            $category->image = NULL;
            $category->save();
            return response()->json(['error' => 0]);
        } else {
            return response()->json(['error' => 1]);
        }
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
