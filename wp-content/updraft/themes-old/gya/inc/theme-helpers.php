<?php

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get an ACF field value with fallback to a default when ACF is not active or field is empty.
 */
function gya_get_field_value($field_name, $default = '', $post_id = null) {
    if (!function_exists('get_field')) {
        return $default;
    }

    $value = get_field($field_name, $post_id);

    if ($value === null || $value === false || $value === '') {
        return $default;
    }

    return $value;
}

/**
 * Get a post-specific ACF field with raw post meta fallback.
 */
function gya_get_post_field_value($field_name, $post_id, $default = '') {
    if (function_exists('get_field')) {
        $value = get_field($field_name, $post_id);
    } else {
        $value = get_post_meta($post_id, $field_name, true);
    }

    if ($value === null || $value === false || $value === '') {
        return $default;
    }

    return $value;
}

/**
 * Build a fixed-length list from ACF fields with per-item defaults.
 */
function gya_get_fixed_items_from_acf($defaults, $prefix, $keys, $count, $post_id = null) {
    $items = $defaults;

    for ($i = 1; $i <= $count; $i++) {
        $index = $i - 1;

        if (!isset($items[$index])) {
            $items[$index] = array();
        }

        foreach ($keys as $key) {
            $field_name = $prefix . '_' . $i . '_' . $key;
            $fallback = isset($items[$index][$key]) ? $items[$index][$key] : '';
            $items[$index][$key] = gya_get_field_value($field_name, $fallback, $post_id);
        }
    }

    return $items;
}
