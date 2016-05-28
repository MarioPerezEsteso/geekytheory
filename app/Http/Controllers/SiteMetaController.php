<?php

namespace App\Http\Controllers;

use App\Repositories\SiteMetaRepository;
use Validator;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\Redirect;

class SiteMetaController extends Controller
{
    /**
     * @var SiteMetaRepository
     */
    protected $repository;

    public function __construct(SiteMetaRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Show the form for editing the site meta.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $siteMeta = self::getSiteMeta();
        $fileUploaders = array(
            'image' => array(
                'title' => trans('home.site_image'),
                'file-input-id' => 'site-image-file-input',
            ),
            'logo' => array(
                'title' => trans('home.site_logo'),
                'file-input-id' => 'site-logo-file-input',
            ),
            'favicon' => array(
                'title' => trans('home.site_favicon'),
                'file-input-id' => 'site-favicon-file-input',
            ),
            'logo_57' => array(
                'title' => trans('home.site_logo_57'),
                'file-input-id' => 'site-logo_57-file-input',
            ),
            'logo_72' => array(
                'title' => trans('home.site_logo_72'),
                'file-input-id' => 'site-logo_72-file-input',
            ),
            'logo_114' => array(
                'title' => trans('home.site_logo_114'),
                'file-input-id' => 'site-logo_114-file-input',
            ),
        );
        return view('home.sitemeta.sitemeta', compact('siteMeta', 'fileUploaders'));
    }

    /**
     * Show the form for editing the menu of the site.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editMenu()
    {
        $menu = json_decode($this->repository->getSiteMeta()->menu, true);
        return view('home.menu.menu', compact('menu'));
    }

    /**
     * Update the site menu
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateMenu(Request $request)
    {
        // TODO: validate json menu
        $siteMeta = $this->repository->getSiteMeta();
        if (!empty($request->menu)) {
            $siteMeta->menu = $request->menu;
            $siteMeta->save();
            return array(
                'error'     => 0,
                'message'   => trans('home.menu_updated_successfully'),
            );
        }
        return array(
            'error'     => 1,
            'message'   => trans('home.menu_not_updated_successfully'),
        );
    }

    /**
     * Return HTML for a new menu item in editor
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getNewMenuItemHtml(Request $request)
    {
        $menuItem = array(
            'text'      => $request->text,
            'link'      => $request->link,
            'submenu'   => null,
        );
        return view('home.menu.menuitemsingle', compact('menuItem'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rules = array(
            'title'         => 'required|max:255',
            'subtitle'      => 'required|max:255',
            'description'   => 'required|max:170',
            'image'         => 'mimes:jpeg,gif,png',
            'logo'          => 'mimes:jpeg,gif,png',
            'favicon'       => 'mimes:jpeg,gif,png',
            'logo_57'       => 'mimes:jpeg,gif,png',
            'logo_72'       => 'mimes:jpeg,gif,png',
            'logo_114'      => 'mimes:jpeg,gif,png',
        );


        /** @var UploadedFile $siteImage */
        $siteImage = $request->file('image');
        /** @var UploadedFile $siteFavicon */
        $siteFavicon = $request->file('favicon');
        /** @var UploadedFile $siteLogo */
        $siteLogo = $request->file('logo');
        /** @var UploadedFile $siteLogo57 */
        $siteLogo57 = $request->file('logo_57');
        /** @var UploadedFile $siteLogo72 */
        $siteLogo72 = $request->file('logo_72');
        /** @var UploadedFile $siteLogo114 */
        $siteLogo114 = $request->file('logo_114');

        $requestParams = array(
            'url'           => $request->url,
            'title'         => $request->title,
            'subtitle'      => $request->subtitle,
            'description'   => $request->description,
            'image'         => $siteImage,
            'logo'          => $siteLogo,
            'favicon'       => $siteFavicon,
            'logo_57'       => $siteLogo57,
            'logo_72'       => $siteLogo72,
            'logo_114'      => $siteLogo114,
        );

        /**
         * Also validate that social networks are URLs
         */
        foreach (self::$socialNetworks as $socialNetwork) {
            // Add social network validators to $rules
            $rules[$socialNetwork] = self::$urlRegexValidator;
            // Add social network form inputs to $requestParams
            $requestParams[$socialNetwork] = $request->get($socialNetwork);
        }

        $validator = Validator::make($requestParams, $rules);

        if ($validator->fails()) {
            return Redirect::to('home/sitemeta')->withErrors($validator->messages());
        } else {
            $siteMeta = self::getSiteMeta();
            $imageItems = array('image', 'logo', 'favicon', 'logo_57', 'logo_72', 'logo_114');
            $siteMeta->update(array_except($requestParams, $imageItems));
            $allowRegister = false;
            if ($request->allow_register && $request->allow_register == 'on') {
                $allowRegister = true;
            }
            $siteMeta->allow_register = $allowRegister;
            foreach ($imageItems as $item) {
                if ($requestParams[$item]) {
                    $fileName = ImageManagerController::getImageName($requestParams[$item], ImageManagerController::PATH_IMAGE_UPLOADS);
                    $siteMeta->setAttribute($item, $fileName);
                    $requestParams[$item]->move(ImageManagerController::PATH_IMAGE_UPLOADS, $fileName);
                }
            }
            $siteMeta->save();
        }
        return Redirect::to('home/sitemeta')->withSuccess(trans('home.sitemeta_update_success'));
    }

    /**
     * Get site meta
     *
     * @return \App\SiteMeta
     */
    public static function getSiteMeta()
    {
        return (new SiteMetaRepository())->getSiteMeta();
    }

    /**
     * Delete image from site_meta (favicon, logo, site image...)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteImage(Request $request)
    {
        if (!empty($request->imageToDelete) && Schema::hasColumn('site_meta', $request->imageToDelete)) {
            $siteMeta = self::getSiteMeta();
            $siteMeta->setAttribute($request->imageToDelete, NULL);
            $siteMeta->save();
            return response()->json(['error' => 0]);
        } else {
            return response()->json(['error' => 1]);
        }
    }

}
