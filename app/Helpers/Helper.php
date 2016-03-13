<?php

use App\Post;

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