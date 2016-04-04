<?php

use App\Post;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Returns class 'active' if the route request matches
 * with the menu item
 *
 * @param string $path
 * @return string
 */
if (!function_exists('classActiveRoute')) {
    function classActiveRoute($path)
    {
        return Request::is($path) ? ' active ' : '';
    }
}

/**
 * Returns pagination text
 *
 * @param Illuminate\Pagination\LengthAwarePaginator $paginator
 * @return string
 */
if (!function_exists('getPaginationText')) {
    function getPaginationText($paginator)
    {
        return trans('home.showing') . ' ' . (($paginator->currentPage() - 1) * $paginator->perPage() + 1) . ' ' . trans('home.to') . ' ' . min($paginator->total(), $paginator->currentPage() * $paginator->perPage()) . ' ' . trans('home.of') . ' ' . $paginator->total() . ' ' . trans('home.posts_min');
    }
}

/**
 * Returns class of post status
 *
 * @param string $status
 * @return string
 */
if (!function_exists('getStatusLabelClass')) {
    function getStatusLabelClass($status)
    {
        $statusClass = 'bg-green';
        switch ($status) {
            case Post::STATUS_PUBLISHED:
                $statusClass = 'bg-green';
                break;
            case Post::STATUS_DRAFT:
                $statusClass = 'bg-blue';
                break;
            case Post::STATUS_DELETED:
                $statusClass = 'bg-red';
                break;
            case Post::STATUS_PENDING:
                $statusClass = 'bg-yellow';
                break;
            case Post::STATUS_SCHEDULED:
                $statusClass = 'bg-orange';
                break;
        }
        return $statusClass;
    }
}

/**
 * Returns slug from a text
 *
 * @see http://stackoverflow.com/a/2955878
 *
 * @param string $text
 * @return string
 */
if (!function_exists('slugify')) {
    function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}

/**
 * Returns name of an image
 */
if (!function_exists('getImageName')) {
    /**
    *  @param string $path
     * @param UploadedFile $image
     * @return string
     */
    function getImageName($image, $path = \App\Http\Controllers\Controller::PATH_IMAGE_UPLOADS)
    {
        $fileExtension = '.' . $image->getClientOriginalExtension();
        $fileName = substr($image->getClientOriginalName(), 0, -1 * strlen($fileExtension));
        $completeFileName = $fileName . $fileExtension;
        $i = 1;
        while (File::exists($path . '/' . $completeFileName)) {
            $completeFileName = $fileName . ' (' . $i++ . ')' . $fileExtension;
        }
        return $completeFileName;
    }
}