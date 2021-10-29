<?php

/*
Plugin Name: WPU Cached
Description: Simple helpers to help you cache anything
Plugin URI: https://github.com/WordPressUtilities/wpu_cached
Version: 0.1.0
Author: Darklg
Author URI: https://darklg.me/
License: MIT License
License URI: http://opensource.org/licenses/MIT
*/

/* ----------------------------------------------------------
  WPDB : Get cached results from database
---------------------------------------------------------- */

/**
 * Get cached results from database
 * @param  string  $type           Type of WPDB get helper
 * @param  string  $q              MySQL Query, already prepared
 * @param  int     $cache_duration Cache duration in seconds
 * @return mixed                   false or array
 */
function wpu_cached__wpdb_get($type, $q, $cache_duration = false) {
    global $wpdb;

    /* Default arguments */
    $cache_duration = $cache_duration ?: 60;
    $type = $type ?: 'col';

    /* Cache key */
    $cache_id = 'wpdb_get_' . $type . '_' . md5($q);

    /* Test cache */
    $result = wp_cache_get($cache_id);

    /* Get results if cache is not available */
    if ($result === false) {
        switch ($type) {
        case 'col':
            $result = $wpdb->get_col($q);
            break;
        }
        wp_cache_set($cache_id, $result, '', $cache_duration);
    }

    return $result;
}
