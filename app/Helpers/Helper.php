<?php

use App\Post;

/**
 * Returns class 'active' if the route request matches
 * with the menu item
 *
 * @param array $paths
 * @return string
 */
if (!function_exists('classActiveRoute')) {
    function classActiveRoute(array $paths)
    {
        $class = '';
        foreach ($paths as $path) {
            if (Request::is($path)) {
                $class = ' active ';
                break;
            }
        }
        return $class;
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
 * Returns slug from a text
 *
 * @see http://stackoverflow.com/a/2955878
 *
 * @param string $text
 * @return string
 */
if (!function_exists('getAvailableSlug')) {
    function getAvailableSlug($text, $table, $column = 'slug')
    {
        $slugAvailable = false;
        $slugSuffix = "";
        $counter = 1;
        while (!$slugAvailable) {
            $slug = slugify($text . $slugSuffix);
            if (DB::table($table)->where($column, $slug)->first() == null) {
                $slugAvailable = true;
            }
            $slugSuffix = "-" . $counter++;
        }
        return $slug;
    }
}

if (!function_exists('getGravatar')) {
    /**
     * Get a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string $email The email address
     * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
     * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     * @return String containing Gravatar URL
     * @source http://gravatar.com/site/implement/images/php/
     */
    function getGravatar($email, $s = '100', $d = 'mm', $r = 'g')
    {
        $url = '//www.gravatar.com/avatar/';
        $url .= md5(strtolower(trim($email)));
        $url .= "?s=$s&d=$d&r=$r";
        return $url;
    }
}

if (!function_exists('getClientIPAddress')) {
    /**
     * Get IP address of a visitor.
     *
     * @return string
     */
    function getClientIPAddress()
    {
        $ipAddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipAddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipAddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipAddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipAddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipAddress = $_SERVER['HTTP_FORWARDED'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ipAddress = $_SERVER['REMOTE_ADDR'];
        }

        return $ipAddress;
    }
}
