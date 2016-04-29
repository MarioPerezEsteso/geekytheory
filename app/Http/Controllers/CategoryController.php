<?php

namespace App\Http\Controllers;

use App\Category;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (empty($request->slug)) {
            if (!empty($request->category)) {
                $slug = $this->getAvailableSlug($request->category);
            }
        } else {
            $slug = $this->getAvailableSlug($request->slug);
        }

        /** @var UploadedFile $image */
        $image = $request->file('image');

        $rules = array(
            'category'  => 'required|unique:categories',
            'slug'      => 'required|unique:categories',
            'image'     => 'mimes:jpeg,gif,png',
        );

        $validator = Validator::make(array('category' => $request->category, 'slug' => $slug, 'image' => $request->file('image')), $rules);

        if ($validator->fails()) {
            return Redirect::to('home/categories')->withErrors($validator->messages());
        } else {
            $category = new Category;
            $category->category = $request->category;
            $category->slug = $slug;
            if ($image) {
                $fileName = ImageManagerController::getImageName($image, ImageManagerController::PATH_IMAGE_UPLOADS);
                $category->image = $fileName;
                $image->move(ImageManagerController::PATH_IMAGE_UPLOADS, $fileName);
            }
            $category->save();
        }

        return Redirect::to('home/categories')->withSuccess(trans('home.category_create_success'));

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
