<?php
/**
 * Dynamic Filtering Functions
 * Handles all product filtering logic
 */

if (!function_exists('applyFilters')) {
    function applyFilters($deals, $filters) {
        if (empty($deals) || !is_array($deals)) {
            return [];
        }

        return array_filter($deals, function($deal) use ($filters) {
            // Store filter
            if (!empty($filters['store'])) {
                if (strtolower($deal['store_name']) !== strtolower($filters['store'])) {
                    return false;
                }
            }

            // Price filters
            $price = floatval($deal['product_offer_price']);
            
            if (!empty($filters['min_price']) && $price < floatval($filters['min_price'])) {
                return false;
            }
            
            if (!empty($filters['max_price']) && $price > floatval($filters['max_price'])) {
                return false;
            }

            // Discount filter
            if (!empty($filters['min_discount'])) {
                $salePrice = floatval($deal['product_sale_price']);
                $offerPrice = floatval($deal['product_offer_price']);
                
                if ($salePrice > 0) {
                    $discount = (($salePrice - $offerPrice) / $salePrice) * 100;
                    if ($discount < floatval($filters['min_discount'])) {
                        return false;
                    }
                }
            }

            // Category filter (keyword matching in product name)
            if (!empty($filters['category'])) {
                $keywords = is_array($filters['category']) ? $filters['category'] : [$filters['category']];
                $productName = strtolower($deal['product_name']);
                
                $found = false;
                foreach ($keywords as $keyword) {
                    if (stripos($productName, $keyword) !== false) {
                        $found = true;
                        break;
                    }
                }
                
                if (!$found) {
                    return false;
                }
            }

            // Search filter
            if (!empty($filters['search'])) {
                $searchTerm = strtolower($filters['search']);
                $productName = strtolower($deal['product_name']);
                
                if (stripos($productName, $searchTerm) === false) {
                    return false;
                }
            }

            return true;
        });
    }
}

if (!function_exists('sortDeals')) {
    function sortDeals($deals, $sortBy = 'discount_desc') {
        if (empty($deals) || !is_array($deals)) {
            return [];
        }

        usort($deals, function($a, $b) use ($sortBy) {
            switch ($sortBy) {
                case 'price_asc':
                    return $a['product_offer_price'] <=> $b['product_offer_price'];
                
                case 'price_desc':
                    return $b['product_offer_price'] <=> $a['product_offer_price'];
                
                case 'discount_desc':
                    $discountA = getDiscountPercentage($a['product_sale_price'], $a['product_offer_price']);
                    $discountB = getDiscountPercentage($b['product_sale_price'], $b['product_offer_price']);
                    return $discountB <=> $discountA;
                
                case 'discount_asc':
                    $discountA = getDiscountPercentage($a['product_sale_price'], $a['product_offer_price']);
                    $discountB = getDiscountPercentage($b['product_sale_price'], $b['product_offer_price']);
                    return $discountA <=> $discountB;
                
                case 'name_asc':
                    return strcasecmp($a['product_name'], $b['product_name']);
                
                case 'name_desc':
                    return strcasecmp($b['product_name'], $a['product_name']);
                
                default:
                    return 0;
            }
        });

        return $deals;
    }
}

if (!function_exists('parseFiltersFromUrl')) {
    function parseFiltersFromUrl() {
        $filters = [];

        // Store filter
        if (!empty($_GET['store'])) {
            $filters['store'] = sanitizeInput($_GET['store']);
        }

        // Price filters
        if (!empty($_GET['min_price'])) {
            $filters['min_price'] = max(0, intval($_GET['min_price']));
        }

        if (!empty($_GET['max_price'])) {
            $filters['max_price'] = max(0, intval($_GET['max_price']));
        }

        // Discount filter
        if (!empty($_GET['min_discount'])) {
            $filters['min_discount'] = max(0, min(100, intval($_GET['min_discount'])));
        }

        // Category filter
        if (!empty($_GET['category'])) {
            $filters['category'] = sanitizeInput($_GET['category']);
        }

        // Search filter
        if (!empty($_GET['search']) || !empty($_GET['q'])) {
            $filters['search'] = sanitizeInput($_GET['search'] ?? $_GET['q']);
        }

        return $filters;
    }
}

if (!function_exists('sanitizeInput')) {
    function sanitizeInput($input) {
        return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('buildFilterTitle')) {
    function buildFilterTitle($filters) {
        $parts = [];
        
        if (!empty($filters['store'])) {
            $parts[] = ucfirst($filters['store']);
        }
        
        if (!empty($filters['category'])) {
            $parts[] = ucfirst($filters['category']);
        }
        
        if (!empty($filters['max_price'])) {
            $parts[] = "Under ₹" . number_format($filters['max_price']);
        } elseif (!empty($filters['min_price'])) {
            $parts[] = "Above ₹" . number_format($filters['min_price']);
        }
        
        if (!empty($filters['min_discount'])) {
            $parts[] = $filters['min_discount'] . "% OFF or More";
        }
        
        if (!empty($filters['search'])) {
            $parts[] = "'" . ucwords($filters['search']) . "'";
        }
        
        if (empty($parts)) {
            return "All Deals";
        }
        
        return implode(' - ', $parts) . " Deals";
    }
}

if (!function_exists('buildFilterDescription')) {
    function buildFilterDescription($filters, $count) {
        $description = "🔥 Discover {$count} amazing deals";
        
        if (!empty($filters['store'])) {
            $description .= " from " . ucfirst($filters['store']);
        }
        
        if (!empty($filters['category'])) {
            $description .= " on " . ucfirst($filters['category']);
        }
        
        if (!empty($filters['max_price'])) {
            $description .= " under ₹" . number_format($filters['max_price']);
        }
        
        if (!empty($filters['min_discount'])) {
            $description .= " with minimum " . $filters['min_discount'] . "% discount";
        }
        
        $description .= "! Updated " . date('F j, Y') . ". Shop today and save big!";
        
        return $description;
    }
}

if (!function_exists('buildCanonicalUrl')) {
    function buildCanonicalUrl($filters) {
        $url = SITE_URL . '/browse';
        
        if (!empty($filters)) {
            $params = [];
            
            if (!empty($filters['store'])) {
                $params[] = 'store=' . urlencode($filters['store']);
            }
            if (!empty($filters['category'])) {
                $params[] = 'category=' . urlencode($filters['category']);
            }
            if (!empty($filters['min_price'])) {
                $params[] = 'min_price=' . $filters['min_price'];
            }
            if (!empty($filters['max_price'])) {
                $params[] = 'max_price=' . $filters['max_price'];
            }
            if (!empty($filters['min_discount'])) {
                $params[] = 'min_discount=' . $filters['min_discount'];
            }
            if (!empty($filters['search'])) {
                $params[] = 'search=' . urlencode($filters['search']);
            }
            
            if (!empty($params)) {
                $url .= '?' . implode('&', $params);
            }
        }
        
        return $url;
    }
}
?>
