<?php

/**
 * Returns class 'active' if the route request matches
 * with the menu item
 *
 * @param $path
 * @return string
 */
if (!function_exists('classActiveRoute')) {
    function classActiveRoute($path)
    {
        return Request::is($path) ? ' active ' : '';
    }
}