<?php

/*
Plugin Name: WPU Cached
Description: Simple helpers to help you cache anything
Plugin URI: https://github.com/WordPressUtilities/wpu_cached
Version: 0.2.0
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
 * @param  string  $cache_key      Cache key
 * @return mixed                   false or array
 */
function wpu_cached__wpdb_get($type, $q, $cache_duration = false, $cache_key = false) {
    global $wpdb;

    /* Default arguments */
    $cache_duration = $cache_duration ?: 60;
    $type = $type ?: 'col';

    $cache_key = $cache_key ? $cache_key : md5($q);

    /* Cache key */
    $cache_id = 'wpdb_get_' . $type . '_' . $cache_key;

    /* Test cache */
    $result = wp_cache_get($cache_id);

    /* Get results if cache is not available */
    if ($result === false) {
        switch ($type) {
        case 'var':
            $result = $wpdb->get_var($q);
            break;
        case 'row':
            $result = $wpdb->get_row($q);
            break;
        case 'col':
            $result = $wpdb->get_col($q);
            break;
        case 'results':
            $result = $wpdb->get_results($q, ARRAY_A);
            break;
        }
        wp_cache_set($cache_id, $result, '', $cache_duration);
    }

    return $result;
}
