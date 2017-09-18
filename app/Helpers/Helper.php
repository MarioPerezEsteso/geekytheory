<?php

use App\Post;
use Illuminate\Support\Facades\Route;

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

if (!function_exists('isRoute')) {
    /**
     * Check if the current route is the given one.
     *
     * @param $route
     * @return bool
     */
    function isRoute($route)
    {
        $currentRoute = Route::current();

        if ($currentRoute) {
            return $currentRoute->getName() == $route;
        }

        return false;
    }
}

/**
 * Returns pagination text
 *
 * @param Illuminate\Pagination\LengthAwarePaginator $paginator
 * @return string
 */
if (!function_exists('getPaginationText')) {
    function getPaginationText($paginator, $item = '')
    {
        return trans('home.showing') . ' '
            . (($paginator->currentPage() - 1) * $paginator->perPage() + 1) . ' '
            . trans('home.to') . ' '
            . min($paginator->total(), $paginator->currentPage() * $paginator->perPage()) . ' '
            . trans('home.of') . ' '
            . $paginator->total() . ' '
            . $item;
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

if (!function_exists('slugify')) {
    /**
     * Returns slug from a text
     *
     * @see http://stackoverflow.com/a/2955878
     *
     * @param string $text
     * @return string
     */
    function slugify($text)
    {
        // Normalize chars
        $text = normalizeChars($text);

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
 * Returns normalized chars
 *
 * @param string $chars
 * @return string
 */
if (!function_exists('normalizeChars')) {
    function normalizeChars($chars)
    {
        $normalizeChars = [
            'Š' => 'S', 'š' => 's', 'Ð' => 'Dj', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A',
            'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I',
            'Ï' => 'I', 'Ñ' => 'N', 'Ń' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U',
            'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a',
            'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i',
            'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ń' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u',
            'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y', 'ƒ' => 'f',
            'ă' => 'a', 'î' => 'i', 'â' => 'a', 'ș' => 's', 'ț' => 't', 'Ă' => 'A', 'Î' => 'I', 'Â' => 'A', 'Ș' => 'S', 'Ț' => 'T',
        ];

        return strtr($chars, $normalizeChars);
    }
}

if (!function_exists('getAvailableSlug')) {
    /**
     * Returns slug from a text
     *
     * @see http://stackoverflow.com/a/2955878
     *
     * @param string $text
     * @return string
     */
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
if (!function_exists('autoVersion')) {
    /**
     * Add version to assets automatically in order to refresh browser cache
     * when they have been modified.
     *
     * @param string $file
     * @return string
     */
    function autoVersion($file = '')
    {
        $absoluteFilePath = $_SERVER['DOCUMENT_ROOT'] . $file;
        if (!file_exists($absoluteFilePath)) {
            return $file;
        }

        $modifiedTime = filemtime($absoluteFilePath);

        return $file . '?version=' . $modifiedTime;
    }
}

if (!function_exists('formatSeconds')) {
    /**
     * Format seconds to 'hh:mm:ss' if hours > 0 or 'mm:ss' if hours < 0.
     *
     * @param integer $seconds
     * @return string
     */
    function formatSeconds($seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor($seconds / 60 % 60);
        $secs = floor($seconds % 60);

        if ($hours > 0) {
            return sprintf('%02d:%02d:%02d', $hours, $minutes, $secs);
        }

        return sprintf('%02d:%02d', $minutes, $secs);
    }
}

if (!function_exists('formatNameToUsername')) {
    /**
     * Format user name to username. For instance: 'Mario Pérez' to 'marioperez'
     *
     * @param string $name
     * @return string
     */
    function formatNameToUsername($name)
    {
        // Normalize chars
        $name = normalizeChars($name);

        // replace non letter or digits by -
        $name = preg_replace('~[^\pL\d]+~u', '', $name);

        // transliterate
        $name = iconv('utf-8', 'us-ascii//TRANSLIT', $name);

        // remove unwanted characters
        $name = preg_replace('~[^-\w]+~', '', $name);

        // trim
        $name = trim($name, '-');

        // remove duplicate -
        $name = preg_replace('~-+~', '', $name);

        // lowercase
        $name = strtolower($name);

        if (empty($name)) {
            return 'n-a';
        }

        return $name;
    }
}

