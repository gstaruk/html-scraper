<?php

namespace App\Helpers;

/**
 * A Collection of helper utilities
 */
class Utilities
{
    /**
     * Format an array as JSON
     * @param $data data array
     * @return json array 
     */
    public static function formatAsJson($data)
    {
        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Convert bytes to Kilobytes
     * @param $bytes the size in bytes
     * @return string size in Kb
     */
    public static function formatBytesToKb($bytes)
    {
        return number_format($bytes / 1024, 2) . 'kb';
    }

    /**
     * Wrap string in HTML pre tags
     * @param $string the original string
     * @return string preformatted text
     */
    public static function formatPre($string)
    {
        return "<pre>{$string}</pre>";
    }
}