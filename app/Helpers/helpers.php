<?php

use Carbon\Carbon;

/**
 * Write code on Method
 *
 * @return response()
 */
if (!function_exists('convertYmdToMdy')) {
    function convertYmdToMdy($date)
    {
        return Carbon::createFromFormat('Y-m-d', $date)->format('m-d-Y');
    }
}

/**
 * Write code on Method
 *
 * @return response()
 */
if (!function_exists('convertMdyToYmd')) {
    function convertMdyToYmd($date)
    {
        return Carbon::createFromFormat('m-d-Y', $date)->format('Y-m-d');
    }
}

/**
 * Date convert into Time Ago
 *
 * @return response()
 */

function convertMdyToTimeAgo($date)
{
    $timestamp = strtotime($date);

    $strTime = array("second", "minute", "hour", "day", "month", "year");
    $length = array("60", "60", "24", "30", "12", "10");

    $currentTime = time();
    if ($currentTime >= $timestamp) {
        $diff     = time() - $timestamp;
        for ($i = 0; $diff >= $length[$i] && $i < count($length) - 1; $i++) {
            $diff = $diff / $length[$i];
        }

        $diff = round($diff);
        return $diff . " " . $strTime[$i] . "s ago ";
    }
}

/**
 * Securely encode a vendor profile ID with HMAC signature
 */
if (!function_exists('encodeVendorId')) {
    function encodeVendorId($id)
    {
        $hash = substr(hash_hmac('sha256', (string)$id, config('app.key')), 0, 6);
        $idBase = base_convert((string)((int)$id + 54321), 10, 36);
        return $idBase . $hash;
    }
}

/**
 * Decode and verify secure vendor profile token/identifier
 */
if (!function_exists('decodeVendorId')) {
    function decodeVendorId($identifier)
    {
        if (empty($identifier)) {
            return null;
        }

        // If numeric ID is passed directly, return it (for backward compatibility)
        if (is_numeric($identifier) && (int)$identifier > 0) {
            return (int)$identifier;
        }

        // Extract token from slug (e.g. "dr-rogelio-pacocha-15wz5e616b" or "15wz5e616b")
        if (preg_match('/([a-z0-9]{7,15})$/i', (string)$identifier, $matches)) {
            $token = $matches[1];
            if (strlen($token) > 6) {
                $hash = substr($token, -6);
                $idBase = substr($token, 0, -6);
                $id = (int)base_convert($idBase, 36, 10) - 54321;
                if ($id > 0) {
                    $expectedHash = substr(hash_hmac('sha256', (string)$id, config('app.key')), 0, 6);
                    if (hash_equals($expectedHash, $hash)) {
                        return $id;
                    }
                }
            }
        }

        return null;
    }
}

/**
 * Generate a secure, SEO-friendly vendor profile URL
 */
if (!function_exists('vendorProfileUrl')) {
    function vendorProfileUrl($profile)
    {
        if (is_numeric($profile)) {
            $id = (int)$profile;
            $slug = 'expert';
        } elseif (is_object($profile)) {
            $id = $profile->id ?? null;
            $name = $profile->vendor->name ?? $profile->vendor->username ?? 'expert';
            $slug = \Illuminate\Support\Str::slug($name);
        } else {
            return url('/');
        }

        if (!$id) {
            return url('/');
        }

        $code = encodeVendorId($id);
        $slugPart = $slug ? $slug . '-' : '';
        return url('vendor-profile/' . $slugPart . $code);
    }
}

