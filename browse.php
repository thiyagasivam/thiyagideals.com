<?php
/**
 * Dynamic Deal Browser
 * SEO-Friendly filtered deal pages
 */

require_once 'includes/config.php';
require_once 'includes/functions.php';
require_once 'includes/filters.php';

// Parse filters from URL
$filters = parseFiltersFromUrl();

// Get sort parameter
$sortBy = !empty($_GET['sort']) ? sanitizeInput($_GET['sort']) : 'discount_desc';

// Get page number
$currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

// Fetch deals from API (fetch more pages for better filtering results)
$apiStartPage = (($currentPage - 1) * 2) + 1;
$allDeals = fetchMultipleEarnPeDeals($apiStartPage, 5); // Fetch 5 pages for more products

// Apply filters
$filteredDeals = applyFilters($allDeals, $filters);

// Sort deals
$filteredDeals = sortDeals($filteredDeals, $sortBy);

// Count results
$totalDeals = count($filteredDeals);

// Pagination
$dealsPerPage = PRODUCTS_PER_PAGE;
$totalPages = ceil($totalDeals / $dealsPerPage);
$offset = ($currentPage - 1) * $dealsPerPage;
$paginatedDeals = array_slice($filteredDeals, $offset, $dealsPerPage);

// SEO Meta Information
$currentYear = date('Y');
$currentDate = date('F j, Y');
$pageTitle = buildFilterTitle($filters) . " " . $currentYear . " | " . SITE_NAME;
$pageDescription = buildFilterDescription($filters, $totalDeals);
$pageKeywords = buildFilterKeywords($filters);

// Canonical URL
$canonicalUrl = buildCanonicalUrl($filters);
if ($currentPage > 1) {
    $canonicalUrl .= (strpos($canonicalUrl, '?') !== false ? '&' : '?') . 'page=' . $currentPage;
}

// Schema.org structured data
$collectionSchema = [
    "@context" => "https://schema.org",
    "@type" => "CollectionPage",
    "name" => buildFilterTitle($filters),
    "description" => $pageDescription,
    "url" => $canonicalUrl,
    "mainEntity" => [
        "@type" => "ItemList",
        "numberOfItems" => $totalDeals,
        "itemListElement" => []
    ],
    "breadcrumb" => [
        "@type" => "BreadcrumbList",
        "itemListElement" => [
            [
                "@type" => "ListItem",
                "position" => 1,
                "name" => "Home",
                "item" => SITE_URL
            ],
            [
                "@type" => "ListItem",
                "position" => 2,
                "name" => "Browse Deals",
                "item" => SITE_URL . "/browse"
            ]
        ]
    ]
];

if (!empty($filters['store'])) {
    $collectionSchema['breadcrumb']['itemListElement'][] = [
        "@type" => "ListItem",
        "position" => 3,
        "name" => ucfirst($filters['store']) . " Deals",
        "item" => $canonicalUrl
    ];
}

$structuredData = $collectionSchema;

// Helper function for keywords
function buildFilterKeywords($filters) {
    $keywords = ["deals " . date('Y'), "offers today", "discounts", "best prices"];
    
    if (!empty($filters['store'])) {
        $keywords[] = $filters['store'] . " deals";
        $keywords[] = $filters['store'] . " offers";
    }
    
    if (!empty($filters['category'])) {
        $keywords[] = $filters['category'] . " deals";
        $keywords[] = $filters['category'] . " offers";
    }
    
    if (!empty($filters['min_discount'])) {
        $keywords[] = $filters['min_discount'] . "% off";
    }
    
    return implode(", ", $keywords);
}

// Include header
include 'includes/header.php';
?>

<style>
    .filter-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
    }
    
    .filter-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 1rem;
    }
    
    .filter-chip {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        color: white;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .filter-chip .remove {
        cursor: pointer;
        font-weight: bold;
        opacity: 0.8;
    }
    
    .filter-chip .remove:hover {
        opacity: 1;
    }
    
    .sort-bar {
        background: white;
        padding: 1rem;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .results-count {
        font-weight: 600;
        color: #333;
    }
    
    .sort-select {
        padding: 0.5rem 1rem;
        border: 1px solid #ddd;
        border-radius: 6px;
        background: white;
        cursor: pointer;
    }
    
    .filter-sidebar {
        background: white;
        padding: 1.5rem;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        position: sticky;
        top: 20px;
    }
    
    .filter-group {
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #eee;
    }
    
    .filter-group:last-child {
        border-bottom: none;
    }
    
    .filter-group h4 {
        font-size: 0.95rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #333;
    }
    
    .filter-input {
        width: 100%;
        padding: 0.6rem;
        border: 1px solid #ddd;
        border-radius: 6px;
        margin-bottom: 0.5rem;
    }
    
    .filter-btn {
        width: 100%;
        padding: 0.8rem;
        background: #667eea;
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s;
    }
    
    .filter-btn:hover {
        background: #5568d3;
    }
    
    .clear-filters {
        width: 100%;
        padding: 0.6rem;
        background: transparent;
        color: #667eea;
        border: 1px solid #667eea;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 0.5rem;
    }
</style>

<div class="container">
    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="<?php echo SITE_URL; ?>">Home</a> / 
        <a href="<?php echo SITE_URL; ?>/browse">Browse</a> /
        <span><?php echo buildFilterTitle($filters); ?></span>
    </nav>

    <!-- Filter Header -->
    <div class="filter-header">
        <h1 class="display-5 fw-bold mb-2"><?php echo buildFilterTitle($filters); ?></h1>
        <p class="mb-0"><?php echo $pageDescription; ?></p>
        
        <?php if (!empty($filters)): ?>
        <div class="filter-chips">
            <?php if (!empty($filters['store'])): ?>
            <div class="filter-chip">
                <i class="bi bi-shop"></i>
                <?php echo ucfirst($filters['store']); ?>
                <span class="remove" onclick="removeFilter('store')">×</span>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($filters['category'])): ?>
            <div class="filter-chip">
                <i class="bi bi-tag"></i>
                <?php echo ucfirst($filters['category']); ?>
                <span class="remove" onclick="removeFilter('category')">×</span>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($filters['max_price'])): ?>
            <div class="filter-chip">
                <i class="bi bi-currency-rupee"></i>
                Under ₹<?php echo number_format($filters['max_price']); ?>
                <span class="remove" onclick="removeFilter('max_price')">×</span>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($filters['min_discount'])): ?>
            <div class="filter-chip">
                <i class="bi bi-percent"></i>
                <?php echo $filters['min_discount']; ?>% OFF+
                <span class="remove" onclick="removeFilter('min_discount')">×</span>
            </div>
            <?php endif; ?>
            
            <a href="<?php echo SITE_URL; ?>/browse" class="filter-chip" style="text-decoration:none; color:white;">
                <i class="bi bi-x-circle"></i> Clear All
            </a>
        </div>
        <?php endif; ?>
    </div>

    <div class="row">
        <!-- Filter Sidebar -->
        <div class="col-lg-3 mb-4">
            <div class="filter-sidebar">
                <h3 class="h5 fw-bold mb-3">
                    <i class="bi bi-funnel me-2"></i>Filters
                </h3>
                
                <form method="GET" action="<?php echo SITE_URL; ?>/browse">
                    <div class="filter-group">
                        <h4>Store</h4>
                        <select name="store" class="filter-input">
                            <option value="">All Stores</option>
                            <option value="amazon" <?php echo (!empty($filters['store']) && $filters['store'] == 'amazon') ? 'selected' : ''; ?>>Amazon</option>
                            <option value="flipkart" <?php echo (!empty($filters['store']) && $filters['store'] == 'flipkart') ? 'selected' : ''; ?>>Flipkart</option>
                            <option value="myntra" <?php echo (!empty($filters['store']) && $filters['store'] == 'myntra') ? 'selected' : ''; ?>>Myntra</option>
                            <option value="ajio" <?php echo (!empty($filters['store']) && $filters['store'] == 'ajio') ? 'selected' : ''; ?>>Ajio</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <h4>Category</h4>
                        <input type="text" name="category" class="filter-input" 
                               placeholder="e.g., mobile, laptop, shoes"
                               value="<?php echo !empty($filters['category']) ? htmlspecialchars($filters['category']) : ''; ?>">
                    </div>
                    
                    <div class="filter-group">
                        <h4>Price Range</h4>
                        <input type="number" name="min_price" class="filter-input" 
                               placeholder="Min Price"
                               value="<?php echo !empty($filters['min_price']) ? $filters['min_price'] : ''; ?>">
                        <input type="number" name="max_price" class="filter-input" 
                               placeholder="Max Price"
                               value="<?php echo !empty($filters['max_price']) ? $filters['max_price'] : ''; ?>">
                    </div>
                    
                    <div class="filter-group">
                        <h4>Minimum Discount</h4>
                        <select name="min_discount" class="filter-input">
                            <option value="">Any Discount</option>
                            <option value="10" <?php echo (!empty($filters['min_discount']) && $filters['min_discount'] == 10) ? 'selected' : ''; ?>>10% or more</option>
                            <option value="25" <?php echo (!empty($filters['min_discount']) && $filters['min_discount'] == 25) ? 'selected' : ''; ?>>25% or more</option>
                            <option value="50" <?php echo (!empty($filters['min_discount']) && $filters['min_discount'] == 50) ? 'selected' : ''; ?>>50% or more</option>
                            <option value="70" <?php echo (!empty($filters['min_discount']) && $filters['min_discount'] == 70) ? 'selected' : ''; ?>>70% or more</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <h4>Search</h4>
                        <input type="text" name="search" class="filter-input" 
                               placeholder="Search products..."
                               value="<?php echo !empty($filters['search']) ? htmlspecialchars($filters['search']) : ''; ?>">
                    </div>
                    
                    <button type="submit" class="filter-btn">
                        <i class="bi bi-search me-2"></i>Apply Filters
                    </button>
                    
                    <a href="<?php echo SITE_URL; ?>/browse" class="clear-filters" style="display:block; text-align:center; text-decoration:none;">
                        <i class="bi bi-x-circle me-2"></i>Clear Filters
                    </a>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <!-- Sort Bar -->
            <div class="sort-bar">
                <div class="results-count">
                    <i class="bi bi-grid-3x3-gap me-2"></i>
                    Showing <?php echo $totalDeals; ?> results
                    <?php if ($currentPage > 1): ?>
                        (Page <?php echo $currentPage; ?> of <?php echo $totalPages; ?>)
                    <?php endif; ?>
                </div>
                
                <div>
                    <label for="sort" style="margin-right: 0.5rem;">Sort by:</label>
                    <select id="sort" class="sort-select" onchange="applySorting(this.value)">
                        <option value="discount_desc" <?php echo $sortBy == 'discount_desc' ? 'selected' : ''; ?>>Highest Discount</option>
                        <option value="price_asc" <?php echo $sortBy == 'price_asc' ? 'selected' : ''; ?>>Price: Low to High</option>
                        <option value="price_desc" <?php echo $sortBy == 'price_desc' ? 'selected' : ''; ?>>Price: High to Low</option>
                        <option value="name_asc" <?php echo $sortBy == 'name_asc' ? 'selected' : ''; ?>>Name: A to Z</option>
                    </select>
                </div>
            </div>

            <?php if (empty($paginatedDeals)): ?>
                <!-- No Results -->
                <div class="text-center py-5">
                    <i class="bi bi-emoji-frown" style="font-size: 4rem; color: #ccc;"></i>
                    <h3 class="mt-3">No deals found</h3>
                    <p class="text-muted">Try adjusting your filters or browse all deals</p>
                    <a href="<?php echo SITE_URL; ?>/browse" class="btn btn-primary mt-3">
                        <i class="bi bi-arrow-left me-2"></i>Browse All Deals
                    </a>
                </div>
            <?php else: ?>
                <!-- Products Grid -->
                <div class="row g-4">
                    <?php foreach ($paginatedDeals as $index => $deal): 
                        $pid = $deal['pid'] ?? crc32($deal['product_name'] . $deal['store_name']);
                        $productName = $deal['product_name'] ?? 'Product';
                        $productImage = $deal['product_image'] ?? 'https://via.placeholder.com/300';
                        $salePrice = $deal['product_sale_price'] ?? 0;
                        $offerPrice = $deal['product_offer_price'] ?? 0;
                        $storeName = $deal['store_name'] ?? 'Store';
                        $productLink = $deal['product_link'] ?? '#';
                        
                        $discount = getDiscountPercentage($salePrice, $offerPrice);
                        $slug = generateSlug($productName);
                        $productUrl = SITE_URL . "/product/" . $pid . "/" . $slug;
                    ?>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="product-card">
                            <a href="<?php echo $productUrl; ?>" class="product-link" data-product-id="<?php echo $pid; ?>">
                                <div class="product-image-wrapper">
                                    <img src="<?php echo htmlspecialchars($productImage); ?>" 
                                         alt="<?php echo htmlspecialchars($productName); ?>"
                                         class="product-image"
                                         loading="<?php echo $index < 3 ? 'eager' : 'lazy'; ?>">
                                    <?php if ($discount > 0): ?>
                                        <div class="discount-badge"><?php echo round($discount); ?>% OFF</div>
                                    <?php endif; ?>
                                </div>
                                <div class="product-info">
                                    <h3 class="product-title"><?php echo htmlspecialchars(truncateText($productName, 50)); ?></h3>
                                    <div class="product-pricing">
                                        <span class="offer-price"><?php echo formatPrice($offerPrice); ?></span>
                                        <?php if ($salePrice > $offerPrice): ?>
                                            <span class="sale-price"><?php echo formatPrice($salePrice); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="product-store">
                                        <i class="bi bi-shop"></i>
                                        <?php echo htmlspecialchars($storeName); ?>
                                    </div>
                                </div>
                            </a>
                            <a href="<?php echo htmlspecialchars($productLink); ?>" 
                               target="_blank" 
                               rel="nofollow noopener"
                               class="buy-now-btn">
                                <i class="bi bi-cart-plus"></i> Buy Now
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <?php if ($totalPages > 1): ?>
                <nav aria-label="Page navigation" class="mt-5">
                    <ul class="pagination justify-content-center">
                        <?php if ($currentPage > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $currentPage - 1])); ?>">
                                <i class="bi bi-chevron-left"></i> Previous
                            </a>
                        </li>
                        <?php endif; ?>
                        
                        <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
                        <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
                            <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                        <?php endfor; ?>
                        
                        <?php if ($currentPage < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $currentPage + 1])); ?>">
                                Next <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </nav>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
function removeFilter(filterName) {
    const url = new URL(window.location);
    url.searchParams.delete(filterName);
    window.location = url.toString();
}

function applySorting(sortValue) {
    const url = new URL(window.location);
    url.searchParams.set('sort', sortValue);
    url.searchParams.delete('page'); // Reset to first page
    window.location = url.toString();
}
</script>

<?php include 'includes/footer.php'; ?>
