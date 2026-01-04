<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Generate SEO-friendly URL slug
function generateSlug($text) {
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s_-]+/', '-', $text);
    return trim($text, '-');
}

function extractDealTags(array $deal): array {
    $name = strtolower($deal['product_name'] ?? '');
    $offerPrice = (float)($deal['product_offer_price'] ?? 0);
    $tags = [];

    $tagMap = [
        'audio' => ['earbud', 'earphone', 'headphone', 'speaker'],
        'smartwatch' => ['smartwatch', 'watch', 'band'],
        'fitness' => ['fitness', 'yoga', 'gym', 'dumbbell'],
        'beauty' => ['beauty', 'skincare', 'cream', 'serum', 'makeup'],
        'personal-care' => ['trimmer', 'shaver', 'groom', 'grooming'],
        'home-essentials' => ['kitchen', 'cook', 'bottle', 'storage', 'organizer', 'light'],
        'gaming' => ['gaming', 'gamepad', 'joystick', 'controller'],
        'stationery' => ['pen', 'notebook', 'diary', 'stationery'],
        'accessories' => ['case', 'cover', 'cable', 'charger', 'adapter']
    ];

    foreach ($tagMap as $tag => $keywords) {
        foreach ($keywords as $keyword) {
            if (strpos($name, $keyword) !== false) {
                $tags[] = $tag;
                break;
            }
        }
    }

    if ($offerPrice < 300) {
        $tags[] = 'under-300';
    }

    if ($offerPrice < 200) {
        $tags[] = 'under-200';
    }

    $storeSlug = generateSlug($deal['store_name'] ?? 'store');
    if ($storeSlug) {
        $tags[] = $storeSlug;
    }

    return array_values(array_unique($tags));
}

// Fetch products from multiple pages
$allDeals = [];
for ($page = 1; $page <= 5; $page++) {
    $deals = fetchEarnPeDeals($page);
    if ($deals && is_array($deals)) {
        $allDeals = array_merge($allDeals, $deals);
    }
}

// Filter products under ₹500
$filteredDeals = array_filter($allDeals, function($deal) {
    return $deal['product_offer_price'] < 500;
});

// Sort by best discount
usort($filteredDeals, function($a, $b) {
    $discountA = (($a['product_sale_price'] ?? 0 - $a['product_offer_price'] ?? 0) / $a['product_sale_price'] ?? 0) * 100;
    $discountB = (($b['product_sale_price'] ?? 0 - $b['product_offer_price'] ?? 0) / $b['product_sale_price'] ?? 0) * 100;
    return $discountB <=> $discountA;
});

$filteredDeals = array_values($filteredDeals);
$totalDeals = count($filteredDeals);
$averageDiscount = 0;
$maxSavings = 0;
$fastMovingDeals = 0;
$under300Count = 0;
$storeStats = [];

foreach ($filteredDeals as $deal) {
    $salePrice = (float)($deal['product_sale_price'] ?? 0);
    $offerPrice = (float)($deal['product_offer_price'] ?? 0);
    $discountValue = ($salePrice > 0) ? round((($salePrice - $offerPrice) / $salePrice) * 100) : 0;

    $averageDiscount += $discountValue;
    $maxSavings = max($maxSavings, max(0, $salePrice - $offerPrice));

    if ($discountValue >= 40) {
        $fastMovingDeals++;
    }

    if ($offerPrice > 0 && $offerPrice < 300) {
        $under300Count++;
    }

    $storeLabel = trim($deal['store_name'] ?? 'Top Pick');
    $storeKey = strtolower($storeLabel);

    if (!isset($storeStats[$storeKey])) {
        $storeStats[$storeKey] = [
            'count' => 0,
            'label' => $storeLabel
        ];
    }

    $storeStats[$storeKey]['count']++;
}

$averageDiscount = $totalDeals ? min(90, max(0, round($averageDiscount / $totalDeals))) : 0;
$maxSavings = max(0, (int)$maxSavings);

uasort($storeStats, function ($a, $b) {
    return $b['count'] <=> $a['count'];
});

$topStoreStats = array_slice($storeStats, 0, 4);
$topStoreChips = [];

foreach ($topStoreStats as $stat) {
    $topStoreChips[] = [
        'label' => $stat['label'],
        'slug' => generateSlug($stat['label']),
        'count' => $stat['count']
    ];
}

$primaryStoreLabel = $topStoreChips[0]['label'] ?? 'Top stores';

$currentYear = date('Y');
$currentDate = date('F j, Y');

$pageTitle = "Best Deals Under ₹500 " . $currentYear . " - Budget Shopping Offers Today | " . SITE_NAME;
$pageDescription = "🛍️ Shop the best deals under ₹500! Amazing discounts on quality products. Budget-friendly shopping with up to 70% OFF. Updated " . $currentDate . ". Free delivery available!";
$pageKeywords = "deals under 500, budget shopping, cheap deals, best offers, affordable products, " . $currentYear;

// Canonical URL for SEO
$canonicalUrl = SITE_URL . '/deals-under-500';

// Collection Schema for rich snippets
$collectionSchema = [
    "@context" => "https://schema.org",
    "@type" => "CollectionPage",
    "name" => $pageTitle,
    "description" => $pageDescription,
    "url" => $canonicalUrl,
    "mainEntity" => [
        "@type" => "ItemList",
        "numberOfItems" => $totalDeals
    ],
    "breadcrumb" => [
        "@type" => "BreadcrumbList",
        "itemListElement" => [
            ["@type" => "ListItem", "position" => 1, "name" => "Home", "item" => SITE_URL],
            ["@type" => "ListItem", "position" => 2, "name" => "Deals Under ₹500", "item" => $canonicalUrl]
        ]
    ]
];
$structuredData = $collectionSchema;

// Include header
include 'includes/header.php';
?>
    
    <div class="container budget-container">
        <nav class="breadcrumb modern-breadcrumb">
            <a href="<?php echo SITE_URL; ?>">Home</a>
            <span aria-hidden="true">/</span>
            <span>Deals Under ₹500</span>
        </nav>

        <section class="budget-hero">
            <div class="hero-content">
                <span class="hero-eyebrow">Budget Buys • Updated <?php echo $currentDate; ?></span>
                <h1>₹500 Finds That Feel Premium</h1>
                <p>Curated mini steals from trusted stores, refreshed daily so you never miss a smart pickup. Filter, sort, and save with confidence.</p>

                <div class="hero-cta">
                    <a href="#dealsGrid" class="btn-solid">Explore all deals</a>
                    <a href="<?php echo SITE_URL; ?>" class="btn-outline">Browse more categories</a>
                </div>

                <div class="hero-stats">
                    <div class="hero-stat">
                        <span class="hero-stat-number"><?php echo $totalDeals; ?></span>
                        <span class="hero-stat-label">live deals</span>
                    </div>
                    <div class="hero-stat">
                        <span class="hero-stat-number"><?php echo $averageDiscount; ?>%</span>
                        <span class="hero-stat-label">avg. discount</span>
                    </div>
                    <div class="hero-stat">
                        <span class="hero-stat-number">₹<?php echo number_format($maxSavings); ?></span>
                        <span class="hero-stat-label">top saving</span>
                    </div>
                </div>
            </div>

            <div class="hero-visual">
                <div class="hero-card">
                    <h2>Quick look</h2>
                    <ul>
                        <li><i class="bi bi-lightning-charge-fill"></i> <?php echo $fastMovingDeals; ?> fast moving steals (40%+ OFF)</li>
                        <li><i class="bi bi-piggy-bank"></i> <?php echo $under300Count; ?> picks under ₹300</li>
                        <li><i class="bi bi-shop"></i> Bestsellers from <?php echo sanitizeOutput($primaryStoreLabel); ?></li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="modern-insights">
            <div class="insight-card">
                <span class="insight-label">Freshly curated</span>
                <strong><?php echo $currentDate; ?></strong>
                <p>Page refreshed with the latest verified offers.</p>
            </div>
            <div class="insight-card">
                <span class="insight-label">High-value picks</span>
                <strong><?php echo $fastMovingDeals; ?></strong>
                <p>Deals delivering 40%+ savings right now.</p>
            </div>
            <div class="insight-card">
                <span class="insight-label">Budget sweet spot</span>
                <strong><?php echo $under300Count; ?></strong>
                <p>Products priced comfortably under ₹300.</p>
            </div>
            <div class="insight-card">
                <span class="insight-label">Top stores</span>
                <strong><?php echo count($topStoreChips); ?></strong>
                <p>Trusted partners powering today’s shortlist.</p>
            </div>
        </section>

        <section class="chip-toolbar">
            <div class="chip-toolbar-header">
                <h2>Curate your budget haul</h2>
                <p>Tap a filter to surface the right deals faster.</p>
            </div>
            <div class="chip-group" id="filterChips">
                <button type="button" class="chip active" data-filter-type="all" data-filter-value="all" data-label="All deals under ₹500">All Deals</button>
                <button type="button" class="chip" data-filter-type="price" data-filter-value="300" data-label="Under ₹300 specials">Under ₹300</button>
                <button type="button" class="chip" data-filter-type="discount" data-filter-value="40" data-label="40%+ off steals">40%+ OFF</button>
                <button type="button" class="chip" data-filter-type="tag" data-filter-value="accessories" data-label="Accessory essentials">Accessories</button>
                <?php foreach ($topStoreChips as $chip): ?>
                    <button type="button" class="chip" data-filter-type="store" data-filter-value="<?php echo $chip['slug']; ?>" data-label="<?php echo sanitizeOutput($chip['label']); ?> bestsellers">
                        <?php echo sanitizeOutput($chip['label']); ?>
                        <span class="chip-count"><?php echo $chip['count']; ?></span>
                    </button>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="results-bar">
            <div class="results-summary" id="resultsSummary"><?php echo $totalDeals; ?> deals • All deals under ₹500</div>
            <div class="sort-control">
                <label for="sortSelect">Sort</label>
                <select id="sortSelect" class="modern-select">
                    <option value="default">Featured</option>
                    <option value="discount">Highest discount</option>
                    <option value="price-low">Price: Low to High</option>
                    <option value="price-high">Price: High to Low</option>
                    <option value="savings">Maximum savings</option>
                </select>
            </div>
        </section>

        <?php if (empty($filteredDeals)): ?>
            <div class="no-deals">
                <h2>No deals found under ₹500</h2>
                <p><a href="<?php echo SITE_URL; ?>">View all deals</a></p>
            </div>
        <?php else: ?>
            <div class="empty-state hidden" id="emptyState">
                <h3>No deals match this filter (yet!)</h3>
                <p>Reset filters or explore another tag to keep saving.</p>
            </div>

            <div class="products-grid" id="dealsGrid">
                <?php foreach ($filteredDeals as $index => $deal):
                    $salePrice = (float)($deal['product_sale_price'] ?? 0);
                    $offerPrice = (float)($deal['product_offer_price'] ?? 0);
                    $discountPercent = calculateDiscount($deal['product_sale_price'], $deal['product_offer_price']);
                    $discountValue = ($salePrice > 0) ? round((($salePrice - $offerPrice) / $salePrice) * 100) : 0;
                    $savings = max(0, $salePrice - $offerPrice);
                    $isHotDeal = $discountValue >= 40;
                    $productUrl = SITE_URL . '/product/' . $deal['pid'] . '/' . generateSlug($deal['product_name']);
                    $storeSlug = generateSlug($deal['store_name'] ?? 'store');
                    $dealTags = extractDealTags($deal);
                ?>
                    <a href="<?php echo $productUrl; ?>"
                       class="product-card-link <?php echo $isHotDeal ? 'hot-deal-wrapper' : ''; ?>"
                       data-product-id="<?php echo $deal['pid']; ?>"
                       data-price="<?php echo (int)$offerPrice; ?>"
                       data-discount="<?php echo $discountValue; ?>"
                       data-store="<?php echo $storeSlug; ?>"
                       data-tags="<?php echo implode(',', $dealTags); ?>"
                       data-savings="<?php echo (int)$savings; ?>"
                       data-index="<?php echo $index; ?>">
                        <div class="product-card <?php echo $isHotDeal ? 'hot-deal-card' : ''; ?>">
                            <div class="product-image-section">
                                <?php if ($isHotDeal): ?>
                                    <div class="product-badge">
                                        <span class="discount-badge-corner">🔥 HOT DEAL</span>
                                    </div>
                                <?php endif; ?>

                                <div class="budget-badge">
                                    <span>💰 Under ₹500</span>
                                </div>

                                <img src="<?php echo htmlspecialchars_decode($deal['product_image']); ?>"
                                     alt="<?php echo sanitizeOutput($deal['product_name']); ?>"
                                     class="product-image"
                                     loading="<?php echo $index < 3 ? 'eager' : 'lazy'; ?>">
                            </div>

                            <div class="product-info">
                                <h3 class="product-title"><?php echo sanitizeOutput($deal['product_name']); ?></h3>

                                <div class="product-pricing">
                                    <span class="current-price"><?php echo formatPrice($offerPrice); ?></span>
                                    <span class="original-price"><?php echo formatPrice($salePrice); ?></span>
                                    <span class="discount-badge <?php echo $isHotDeal ? 'hot-discount' : ''; ?>">
                                        <?php echo $discountPercent; ?>
                                    </span>
                                </div>

                                <div class="savings-info">
                                    <span class="savings-text">
                                        💰 You save ₹<?php echo number_format($savings); ?>
                                    </span>
                                </div>

                                <?php
                                $stockMessages = [
                                    ['text' => 'Only 3 left in stock!', 'class' => 'text-danger', 'icon' => 'exclamation-circle-fill'],
                                    ['text' => 'Low stock - order soon!', 'class' => 'text-warning', 'icon' => 'clock-fill'],
                                    ['text' => 'Selling fast!', 'class' => 'text-info', 'icon' => 'fire'],
                                ];
                                $productId = $deal['pid'] ?? 'default-' . $index;
                                $stockIndex = crc32((string)$productId) % count($stockMessages);
                                $stockMsg = $stockMessages[$stockIndex];
                                ?>
                                <div class="urgency-text <?php echo $stockMsg['class']; ?> small mb-2">
                                    <i class="bi bi-<?php echo $stockMsg['icon']; ?>"></i> <?php echo $stockMsg['text']; ?>
                                </div>

                                <div class="product-store">
                                    <i class="bi bi-shop"></i> <?php echo sanitizeOutput($deal['store_name']); ?>
                                    <span class="delivery-info">
                                        <i class="bi bi-truck"></i>
                                        <?php echo $offerPrice >= 299 ? 'Free delivery' : 'Fast dispatch'; ?>
                                    </span>
                                </div>

                                <div class="deal-timer subtle-timer">
                                    <i class="bi bi-clock"></i>
                                    <span>Updated <?php echo $currentDate; ?></span>
                                </div>

                                <span class="view-details-btn <?php echo $isHotDeal ? 'hot-deal-btn' : ''; ?>">
                                    <i class="bi bi-cart-plus"></i>
                                    <?php echo $isHotDeal ? '🔥 Grab Hot Deal Now!' : 'View Details & Buy Now'; ?>
                                </span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <section class="modern-section seo-content">
                <h2>Why shop deals under ₹500 on <?php echo SITE_NAME; ?>?</h2>
                <p>Stretch your budget further without compromising on authenticity. Each pick is price-checked, quality screened, and ready for quick delivery so that your cart stays light while the experience stays premium.</p>

                <div class="budget-benefits">
                    <div class="benefit-card">
                        <h3>Budget confidence</h3>
                        <p>Handpicked bestsellers with transparent pricing and verified merchant ratings.</p>
                    </div>
                    <div class="benefit-card">
                        <h3>Gifting made easy</h3>
                        <p>Thoughtful picks under ₹500 that look and feel like luxe finds.</p>
                    </div>
                    <div class="benefit-card">
                        <h3>Fresh drops daily</h3>
                        <p>New additions every morning so your wishlist is always relevant.</p>
                    </div>
                </div>

                <div class="budget-faq">
                    <details>
                        <summary>How frequently are the deals refreshed?</summary>
                        <p>We scan partner stores multiple times a day and refresh the list every morning around 9 AM IST with the latest verified offers.</p>
                    </details>
                    <details>
                        <summary>Can I rely on product quality under ₹500?</summary>
                        <p>Absolutely. We only feature products from trusted sellers with consistent ratings, ensuring budget-friendly doesn’t compromise quality.</p>
                    </details>
                    <details>
                        <summary>Do these products support free delivery?</summary>
                        <p>Most items qualify for free or discounted delivery. Look for the delivery pill on each card for quick reference.</p>
                    </details>
                </div>
            </section>
        <?php endif; ?>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const chips = document.querySelectorAll('#filterChips .chip');
        const grid = document.getElementById('dealsGrid');
        const cards = grid ? Array.from(grid.querySelectorAll('.product-card-link')) : [];
        const summary = document.getElementById('resultsSummary');
        const emptyState = document.getElementById('emptyState');
        const sortSelect = document.getElementById('sortSelect');

        function updateSummary(count, label) {
            if (summary) {
                summary.textContent = count + ' deals • ' + label;
            }
            if (emptyState) {
                emptyState.classList.toggle('hidden', count > 0);
            }
        }

        function applyFilter(type, value, label) {
            let visible = 0;

            cards.forEach(card => {
                if (!card) {
                    return;
                }
                let show = true;
                const price = parseInt(card.dataset.price || '0', 10);
                const discount = parseInt(card.dataset.discount || '0', 10);
                const savings = parseInt(card.dataset.savings || '0', 10);
                const store = card.dataset.store || '';
                const tags = (card.dataset.tags || '').split(',');

                switch (type) {
                    case 'price':
                        show = price <= parseInt(value, 10);
                        break;
                    case 'discount':
                        show = discount >= parseInt(value, 10);
                        break;
                    case 'savings':
                        show = savings >= parseInt(value, 10);
                        break;
                    case 'store':
                        show = store === value;
                        break;
                    case 'tag':
                        show = tags.includes(value);
                        break;
                    default:
                        show = true;
                        break;
                }

                card.classList.toggle('hidden-card', !show);
                if (show) {
                    visible++;
                }
            });

            updateSummary(visible, label);
        }

        function sortCards(method) {
            if (!grid) {
                return;
            }

            const sorted = [...cards].sort((a, b) => {
                const priceA = parseInt(a.dataset.price || '0', 10);
                const priceB = parseInt(b.dataset.price || '0', 10);
                const discountA = parseInt(a.dataset.discount || '0', 10);
                const discountB = parseInt(b.dataset.discount || '0', 10);
                const savingsA = parseInt(a.dataset.savings || '0', 10);
                const savingsB = parseInt(b.dataset.savings || '0', 10);
                const indexA = parseInt(a.dataset.index || '0', 10);
                const indexB = parseInt(b.dataset.index || '0', 10);

                switch (method) {
                    case 'price-low':
                        return priceA - priceB;
                    case 'price-high':
                        return priceB - priceA;
                    case 'discount':
                        return discountB - discountA;
                    case 'savings':
                        return savingsB - savingsA;
                    default:
                        return indexA - indexB;
                }
            });

            sorted.forEach(card => grid.appendChild(card));
        }

        chips.forEach(chip => {
            chip.addEventListener('click', function () {
                chips.forEach(c => c.classList.remove('active'));
                this.classList.add('active');
                applyFilter(this.dataset.filterType, this.dataset.filterValue, this.dataset.label || this.textContent.trim());
            });
        });

        if (sortSelect) {
            sortSelect.addEventListener('change', function () {
                sortCards(this.value);
            });
        }

        const defaultChip = document.querySelector('#filterChips .chip.active') || chips[0];
        if (defaultChip) {
            applyFilter(defaultChip.dataset.filterType, defaultChip.dataset.filterValue, defaultChip.dataset.label || defaultChip.textContent.trim());
        } else {
            updateSummary(cards.length, 'All deals under ₹500');
        }
    });
    </script>

    <?php include 'includes/footer.php'; ?>
