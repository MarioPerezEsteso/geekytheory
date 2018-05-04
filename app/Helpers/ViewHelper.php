<?php

use App\SiteMeta;

/**
 * These methods are helpers to be used in Blade templates.
 */

/**
 * Method to check if banners should be shown.
 *
 * @param array $user
 * @param SiteMeta $user
 * @return bool
 */
if (!function_exists('showBanner')) {
    function showBanner($user, $siteMeta)
    {
        if (isPremiumUser($user)) {
            return false;
        }

        return $siteMeta->adsense_enabled === 1;
    }
}

/**
 * Method to check if a user is Premium or not.
 *
 * @param array $paths
 * @return string
 */
if (!function_exists('isPremiumUser')) {
    function isPremiumUser($user)
    {
        if (!isset($user) || (isset($user) && !$user['premium'])) {
            return false;
        }

        return true;
    }
}
