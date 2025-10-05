# Thiyagi Deals - AI Coding Guidelines

## Project Architecture

This is a PHP-based e-commerce deals aggregation website that fetches product data from the EarnPe API and displays filtered deal pages. The site features 54+ specialized deal pages with different filtering criteria.

### Core Structure
- **Entry Point**: `index.php` - Main deals listing with pagination
- **API Integration**: `includes/functions.php` - EarnPe API wrapper functions
- **Configuration**: `includes/config.php` - API keys, site settings, database config
- **Templates**: `includes/header.php`, `includes/footer.php` - Shared layout components
- **Deal Pages**: Individual PHP files (e.g., `amazon-deals.php`, `deals-under-1000.php`) - Filtered product listings

### Data Flow Pattern
1. **API Fetching**: `fetchEarnPeDeals($page)` - Single page API call
2. **Multi-page Fetching**: `fetchMultipleEarnPeDeals()` - Combines multiple API pages for more products
3. **Filtering**: Array filtering based on price ranges, discount percentages, or store names
4. **Display**: Standard product card layout with pricing, discounts, and CTAs

## Critical Development Patterns

### Deal Page Structure
All deal pages follow this pattern:
```php
<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Fetch and filter products
$allDeals = [];
for ($page = 1; $page <= 5; $page++) {
    $deals = fetchEarnPeDeals($page);
    if ($deals && is_array($deals)) {
        $allDeals = array_merge($allDeals, $deals);
    }
}

// Apply specific filters (price, discount, store, etc.)
$filteredDeals = array_filter($allDeals, function($deal) {
    // Filter logic here
});

// Sort by discount percentage (highest first)
usort($filteredDeals, function($a, $b) {
    $discountA = (($a['product_sale_price'] - $a['product_offer_price']) / $a['product_sale_price']) * 100;
    $discountB = (($b['product_sale_price'] - $b['product_offer_price']) / $b['product_sale_price']) * 100;
    return $discountB <=> $discountA;
});
```

### Key Constants & Configuration
- `PRODUCTS_PER_PAGE` (30) - Products shown per page
- `API_PAGES_TO_FETCH` (3) - API pages combined for each request
- `SITE_URL`, `SITE_NAME` - Base site configuration
- API credentials: `EARNPE_API_KEY`, `EARNPE_USER_ID`, `EARNPE_TOKEN`

### Product Card Schema
Each product has these key fields:
- `pid` - Product ID
- `product_name` - Title
- `product_image` - Image URL
- `product_sale_price` - Original price
- `product_offer_price` - Discounted price
- `store_name` - Retailer (Amazon, Flipkart, etc.)

## Automation & Bulk Operations

### Page Generation System
- **Generator Scripts**: `generate-pages-config.php`, `generate-pages-execute.php`
- **Batch Processing**: PowerShell scripts (`.ps1`) for bulk modifications
- **UI Enhancement**: `apply-ui-enhancements-bulk.php` for styling updates
- **Bug Fixes**: Scripts like `fix-all-pages-comprehensive.php` for mass corrections

### Development Workflow
1. **Create New Deal Pages**: Use `generate-pages-config.php` as template
2. **Bulk Updates**: Use PowerShell scripts for consistent changes across all files
3. **Testing**: `function-test.php` for API testing
4. **Documentation**: Auto-generated reports in `.md` files track changes

## SEO & Performance Patterns

### SEO Structure
- **Schema.org**: CollectionPage and ItemList schemas on all deal pages
- **Meta Tags**: Dynamic titles, descriptions with year/date
- **Canonicals**: Proper URL structure with pagination
- **Breadcrumbs**: Consistent navigation structure
- **Image Optimization**: Lazy loading after first 6 products

### URL Structure
- Product details: `/product/{pid}/{slug}`
- Deal pages: `/{page-name}.php` (e.g., `/amazon-deals.php`)
- Clean URLs via `.htaccess` rewriting

## Common Anti-Patterns to Avoid

1. **Multiple API Calls**: Always use `fetchMultipleEarnPeDeals()` instead of individual calls
2. **Missing Error Handling**: API calls can fail - always check `is_array($deals)`
3. **Hardcoded Values**: Use constants from `config.php`
4. **Duplicate Code**: Reuse filtering patterns from existing deal pages
5. **Missing Documentation**: Update corresponding `.md` files when making bulk changes

## File Naming Conventions

- Deal pages: `{category}-deals.php` or `deals-{criteria}.php`
- Backup files: `{filename}.backup_{timestamp}`
- Generator scripts: `generate-{type}-pages.php`
- Fix scripts: `fix-{issue}-{scope}.php`
- Documentation: `{SCOPE}_{TYPE}_REPORT.md`

## Mobile & UI Patterns

- **Responsive Design**: Bootstrap-based with custom CSS
- **Mobile Tracking**: `data-product-id` attributes on all product links
- **Loading States**: Progressive image loading with `loading="lazy"`
- **Accessibility**: Alt texts, semantic HTML structure

When creating new deal pages, always follow the established filtering patterns and include proper SEO metadata, schema markup, and responsive design elements.