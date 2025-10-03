<?php
/**
 * EarnPe API Integration Functions
 * Functions for handling EarnPe deals and products
 * 
 * This file should be included only once using require_once
 */

// Prevent multiple inclusions with a unique constant
if (defined('SHOP_FUNCTIONS_LOADED')) {
    return; // Exit if already loaded
}
define('SHOP_FUNCTIONS_LOADED', true);

if (!function_exists('fetchEarnPeDeals')) {
    function fetchEarnPeDeals($page = 1) {
        $url = EARNPE_API_URL . '?apikey=' . EARNPE_API_KEY . '&page=' . $page;
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'User-Id: ' . EARNPE_USER_ID,
                'Authorization: Bearer ' . EARNPE_TOKEN
            ),
        ));
        
        $response = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($curl);
        curl_close($curl);
        
        if ($curl_error) {
            error_log("CURL Error: " . $curl_error);
            return false;
        }
        
        if ($http_code === 200 && $response) {
            $decoded = json_decode($response, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $decoded;
            } else {
                error_log("JSON Decode Error: " . json_last_error_msg());
                return false;
            }
        }
        
        error_log("API Error: HTTP Code $http_code, Response: $response");
        return false;
    }
}

// New function to fetch multiple pages of deals for showing more products
if (!function_exists('fetchMultipleEarnPeDeals')) {
    function fetchMultipleEarnPeDeals($startPage = 1, $totalPages = 3) {
        $allDeals = array();
        
        for ($page = $startPage; $page < $startPage + $totalPages; $page++) {
            $deals = fetchEarnPeDeals($page);
            if ($deals && is_array($deals)) {
                $allDeals = array_merge($allDeals, $deals);
            }
            
            // Small delay to be respectful to the API
            usleep(100000); // 0.1 second delay between requests
        }
        
        return $allDeals;
    }
}

if (!function_exists('formatPrice')) {
    function formatPrice($price) {
        return '₹' . number_format($price);
    }
}

if (!function_exists('calculateDiscount')) {
    function calculateDiscount($original, $sale) {
        if ($original <= 0) return '0% OFF';
        $discount = (($original - $sale) / $original) * 100;
        return round($discount) . '% OFF';
    }
}

if (!function_exists('getDiscountPercentage')) {
    function getDiscountPercentage($original, $sale) {
        $original = floatval($original);
        $sale = floatval($sale);
        if ($original <= 0 || $sale <= 0) return 0;
        $discount = (($original - $sale) / $original) * 100;
        return round($discount, 2);
    }
}

if (!function_exists('sanitizeOutput')) {
    function sanitizeOutput($data) {
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('getProductById')) {
    function getProductById($pid) {
        // Search through multiple pages to find the product
        for ($page = 1; $page <= 10; $page++) {
            $deals = fetchEarnPeDeals($page);
            if ($deals && is_array($deals)) {
                foreach ($deals as $deal) {
                    if (isset($deal['pid']) && $deal['pid'] == $pid) {
                        return $deal;
                    }
                }
            } else {
                // If no deals on this page, stop searching
                break;
            }
        }
        return false;
    }
}

if (!function_exists('truncateText')) {
    function truncateText($text, $length = 100) {
        if (strlen($text) <= $length) {
            return $text;
        }
        return substr($text, 0, $length) . '...';
    }
}

if (!function_exists('generateSlug')) {
    function generateSlug($text) {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $text)));
    }
}

if (!function_exists('createSlug')) {
    function createSlug($text) {
        // Alias for generateSlug
        return generateSlug($text);
    }
}

// End of functions file
?>