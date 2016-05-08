<?php

namespace App\Http\Controllers;

use App\Repositories\SiteMetaRepository;
use App\SiteMeta;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Schema;

class SiteMetaController extends Controller
{
    /**
     * Show the form for editing the specified resource.
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
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
