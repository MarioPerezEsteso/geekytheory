<?php

namespace App\Http\Controllers;

use App\Article;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class SitemapController extends Controller
{
    /**
     * @param Request $request
     * @return mixed
     */
    public function articles(Request $request)
    {
        /** @var Collection $articles */
        $articles = Article::findAllPublished();

        $urls = [];
        foreach ($articles as $article) {
            $urls[] = [
                'loc' => route('article', ['slug' => $article->slug]),
                'lastmod' => $article->created_at->format('Y-m-d'),
                'changefreq' => 'daily',
                'priority' => '0.6',
            ];
        }

        $contents = View::make('sitemap.xml')->with('urls', $urls);
        $response = Response::make($contents, 200);
        $response->header('Content-Type', 'application/xml');

        return $response;
    }
}
