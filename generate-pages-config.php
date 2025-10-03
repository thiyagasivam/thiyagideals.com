<?php
/**
 * Automated Page Generator for Shop Deals
 * Creates 50+ specialized deal pages based on different filters
 */

// Page configurations
$pages = [
    // Price-based pages
    [
        'filename' => 'deals-under-1000.php',
        'title' => 'Best Deals Under ₹1000',
        'filter' => ['type' => 'price', 'max' => 1000],
        'color' => '#28a745',
        'icon' => '💰',
        'description' => 'Amazing deals under ₹1000 with great discounts'
    ],
    [
        'filename' => 'deals-under-2000.php',
        'title' => 'Best Deals Under ₹2000',
        'filter' => ['type' => 'price', 'max' => 2000],
        'color' => '#28a745',
        'icon' => '💰',
        'description' => 'Premium quality products under ₹2000'
    ],
    [
        'filename' => 'deals-500-1000.php',
        'title' => 'Deals Between ₹500-1000',
        'filter' => ['type' => 'price', 'min' => 500, 'max' => 1000],
        'color' => '#17a2b8',
        'icon' => '💵',
        'description' => 'Mid-range deals with best value for money'
    ],
    [
        'filename' => 'deals-1000-5000.php',
        'title' => 'Deals Between ₹1000-5000',
        'filter' => ['type' => 'price', 'min' => 1000, 'max' => 5000],
        'color' => '#17a2b8',
        'icon' => '💵',
        'description' => 'Quality products in ₹1000-5000 range'
    ],
    [
        'filename' => 'premium-deals.php',
        'title' => 'Premium Deals (₹5000+)',
        'filter' => ['type' => 'price', 'min' => 5000],
        'color' => '#ffd700',
        'icon' => '⭐',
        'description' => 'Premium and luxury products with exclusive discounts'
    ],
    [
        'filename' => 'luxury-deals.php',
        'title' => 'Luxury Deals (₹10000+)',
        'filter' => ['type' => 'price', 'min' => 10000],
        'color' => '#c9a500',
        'icon' => '👑',
        'description' => 'Luxury products with massive savings'
    ],
    
    // Discount-based pages
    [
        'filename' => 'super-saver.php',
        'title' => 'Super Saver - 50% OFF or More',
        'filter' => ['type' => 'discount', 'min' => 50],
        'color' => '#dc3545',
        'icon' => '💥',
        'description' => 'Incredible deals with 50% or more discount'
    ],
    [
        'filename' => 'mega-discounts.php',
        'title' => 'Mega Discounts - 60% OFF or More',
        'filter' => ['type' => 'discount', 'min' => 60],
        'color' => '#e74c3c',
        'icon' => '🎯',
        'description' => 'Massive discounts of 60% and above'
    ],
    [
        'filename' => 'deals-25-percent-off.php',
        'title' => 'Minimum 25% OFF Deals',
        'filter' => ['type' => 'discount', 'min' => 25],
        'color' => '#ff6347',
        'icon' => '🔥',
        'description' => 'Great deals with at least 25% discount'
    ],
    [
        'filename' => 'deals-30-percent-off.php',
        'title' => 'Minimum 30% OFF Deals',
        'filter' => ['type' => 'discount', 'min' => 30],
        'color' => '#ff4500',
        'icon' => '🔥',
        'description' => 'Exciting deals with 30% or more discount'
    ],
    [
        'filename' => 'clearance-sale.php',
        'title' => 'Clearance Sale - 70% OFF or More',
        'filter' => ['type' => 'discount', 'min' => 70],
        'color' => '#8b0000',
        'icon' => '💣',
        'description' => 'Ultimate clearance with 70%+ discounts'
    ],
    
    // Store-specific pages
    [
        'filename' => 'flipkart-deals.php',
        'title' => 'Flipkart Deals Today',
        'filter' => ['type' => 'store', 'name' => 'Flipkart'],
        'color' => '#2874f0',
        'icon' => '🛒',
        'description' => 'Best Flipkart deals and offers today'
    ],
    
    // Time-based pages
    [
        'filename' => 'todays-deals.php',
        'title' => "Today's Top Deals",
        'filter' => ['type' => 'today'],
        'color' => '#667eea',
        'icon' => '📅',
        'description' => 'Fresh deals added today with best discounts'
    ],
    [
        'filename' => 'weekly-deals.php',
        'title' => 'This Week\'s Best Deals',
        'filter' => ['type' => 'week'],
        'color' => '#764ba2',
        'icon' => '📆',
        'description' => 'Top deals of the week with huge savings'
    ],
    [
        'filename' => 'weekend-special.php',
        'title' => 'Weekend Special Offers',
        'filter' => ['type' => 'weekend'],
        'color' => '#f093fb',
        'icon' => '🎉',
        'description' => 'Exclusive weekend deals and offers'
    ],
    [
        'filename' => 'flash-sale.php',
        'title' => 'Flash Sale - Limited Time',
        'filter' => ['type' => 'flash'],
        'color' => '#ff6b6b',
        'icon' => '⚡',
        'description' => 'Lightning deals - grab before they\'re gone'
    ],
    
    // Special collections
    [
        'filename' => 'new-arrivals.php',
        'title' => 'New Arrivals - Latest Deals',
        'filter' => ['type' => 'new'],
        'color' => '#4facfe',
        'icon' => '🆕',
        'description' => 'Newest deals and latest product offers'
    ],
    [
        'filename' => 'trending.php',
        'title' => 'Trending Deals Now',
        'filter' => ['type' => 'trending'],
        'color' => '#fa709a',
        'icon' => '📈',
        'description' => 'Most popular and trending deals right now'
    ],
    [
        'filename' => 'best-sellers.php',
        'title' => 'Best Selling Products',
        'filter' => ['type' => 'bestseller'],
        'color' => '#fee140',
        'icon' => '🏆',
        'description' => 'Top selling products with amazing deals'
    ],
    [
        'filename' => 'editors-choice.php',
        'title' => 'Editor\'s Choice Deals',
        'filter' => ['type' => 'featured'],
        'color' => '#a8edea',
        'icon' => '✨',
        'description' => 'Hand-picked deals by our expert team'
    ],
    [
        'filename' => 'limited-stock.php',
        'title' => 'Limited Stock - Hurry Up!',
        'filter' => ['type' => 'limited'],
        'color' => '#ff6b6b',
        'icon' => '⚠️',
        'description' => 'Almost sold out - grab before it\'s gone'
    ],
    [
        'filename' => 'free-delivery.php',
        'title' => 'Free Delivery Offers',
        'filter' => ['type' => 'free_delivery'],
        'color' => '#20c997',
        'icon' => '🚚',
        'description' => 'Products with free home delivery'
    ],
    
    // Savings-focused pages
    [
        'filename' => 'maximum-savings.php',
        'title' => 'Maximum Savings Deals',
        'filter' => ['type' => 'max_savings'],
        'color' => '#28a745',
        'icon' => '💸',
        'description' => 'Highest rupee savings on products'
    ],
    [
        'filename' => 'best-value.php',
        'title' => 'Best Value for Money',
        'filter' => ['type' => 'best_value'],
        'color' => '#17a2b8',
        'icon' => '💎',
        'description' => 'Perfect balance of price and quality'
    ],
    [
        'filename' => 'combo-deals.php',
        'title' => 'Combo & Bundle Offers',
        'filter' => ['type' => 'combo'],
        'color' => '#fd7e14',
        'icon' => '🎁',
        'description' => 'Multi-pack and combo deals'
    ],
    
    // Category simulation pages
    [
        'filename' => 'electronics-deals.php',
        'title' => 'Electronics & Gadgets Deals',
        'filter' => ['type' => 'category', 'keywords' => ['electronic', 'gadget', 'phone', 'laptop', 'camera']],
        'color' => '#3498db',
        'icon' => '📱',
        'description' => 'Best deals on electronics and gadgets'
    ],
    [
        'filename' => 'fashion-deals.php',
        'title' => 'Fashion & Accessories',
        'filter' => ['type' => 'category', 'keywords' => ['shirt', 'shoe', 'watch', 'bag', 'cloth']],
        'color' => '#e91e63',
        'icon' => '👗',
        'description' => 'Trendy fashion deals and accessories'
    ],
    [
        'filename' => 'home-kitchen.php',
        'title' => 'Home & Kitchen Essentials',
        'filter' => ['type' => 'category', 'keywords' => ['kitchen', 'home', 'appliance', 'furniture']],
        'color' => '#ff9800',
        'icon' => '🏠',
        'description' => 'Home and kitchen products at best prices'
    ],
    [
        'filename' => 'beauty-deals.php',
        'title' => 'Beauty & Personal Care',
        'filter' => ['type' => 'category', 'keywords' => ['beauty', 'cosmetic', 'care', 'perfume', 'cream']],
        'color' => '#e91e63',
        'icon' => '💄',
        'description' => 'Beauty products and personal care deals'
    ],
    [
        'filename' => 'sports-fitness.php',
        'title' => 'Sports & Fitness Gear',
        'filter' => ['type' => 'category', 'keywords' => ['sport', 'fitness', 'gym', 'yoga', 'exercise']],
        'color' => '#4caf50',
        'icon' => '⚽',
        'description' => 'Sports equipment and fitness gear deals'
    ],
    [
        'filename' => 'books-media.php',
        'title' => 'Books & Media',
        'filter' => ['type' => 'category', 'keywords' => ['book', 'novel', 'magazine', 'music', 'movie']],
        'color' => '#795548',
        'icon' => '📚',
        'description' => 'Books, music and media deals'
    ],
    [
        'filename' => 'toys-kids.php',
        'title' => 'Toys & Kids Products',
        'filter' => ['type' => 'category', 'keywords' => ['toy', 'kid', 'baby', 'child', 'game']],
        'color' => '#ff5722',
        'icon' => '🧸',
        'description' => 'Toys and kids products at best prices'
    ],
    [
        'filename' => 'automotive.php',
        'title' => 'Automotive & Accessories',
        'filter' => ['type' => 'category', 'keywords' => ['car', 'bike', 'automotive', 'vehicle', 'auto']],
        'color' => '#607d8b',
        'icon' => '🚗',
        'description' => 'Automotive products and accessories'
    ],
    [
        'filename' => 'health-wellness.php',
        'title' => 'Health & Wellness',
        'filter' => ['type' => 'category', 'keywords' => ['health', 'wellness', 'vitamin', 'supplement', 'medical']],
        'color' => '#4caf50',
        'icon' => '🏥',
        'description' => 'Health and wellness products'
    ],
    [
        'filename' => 'pet-supplies.php',
        'title' => 'Pet Supplies & Accessories',
        'filter' => ['type' => 'category', 'keywords' => ['pet', 'dog', 'cat', 'animal', 'bird']],
        'color' => '#9c27b0',
        'icon' => '🐾',
        'description' => 'Pet care and supplies at great prices'
    ],
    
    // Event-based pages
    [
        'filename' => 'festival-sale.php',
        'title' => 'Festival Sale - Special Offers',
        'filter' => ['type' => 'festival'],
        'color' => '#ff9800',
        'icon' => '🎆',
        'description' => 'Festival special deals and offers'
    ],
    [
        'filename' => 'month-end-sale.php',
        'title' => 'Month End Clearance Sale',
        'filter' => ['type' => 'month_end'],
        'color' => '#e74c3c',
        'icon' => '📉',
        'description' => 'Month end clearance with huge discounts'
    ],
    [
        'filename' => 'payday-special.php',
        'title' => 'Payday Special Offers',
        'filter' => ['type' => 'payday'],
        'color' => '#27ae60',
        'icon' => '💰',
        'description' => 'Special deals for payday shopping'
    ],
    [
        'filename' => 'midnight-deals.php',
        'title' => 'Midnight Sale - Special Prices',
        'filter' => ['type' => 'midnight'],
        'color' => '#2c3e50',
        'icon' => '🌙',
        'description' => 'Exclusive midnight deals and offers'
    ],
    
    // Price comparison pages
    [
        'filename' => 'price-drop-alert.php',
        'title' => 'Price Drop Alert - Massive Savings',
        'filter' => ['type' => 'price_drop'],
        'color' => '#e67e22',
        'icon' => '📉',
        'description' => 'Recent price drops with best savings'
    ],
    [
        'filename' => 'lowest-prices.php',
        'title' => 'Lowest Prices Ever',
        'filter' => ['type' => 'lowest'],
        'color' => '#16a085',
        'icon' => '🎯',
        'description' => 'All-time lowest prices on products'
    ],
    
    // Additional special pages
    [
        'filename' => 'recommended-deals.php',
        'title' => 'Recommended For You',
        'filter' => ['type' => 'recommended'],
        'color' => '#9b59b6',
        'icon' => '🎁',
        'description' => 'Personalized deals based on your interest'
    ],
    [
        'filename' => 'top-rated.php',
        'title' => 'Top Rated Products',
        'filter' => ['type' => 'top_rated'],
        'color' => '#f39c12',
        'icon' => '⭐',
        'description' => 'Highest rated products with best reviews'
    ],
    [
        'filename' => 'most-saved.php',
        'title' => 'Most Saved Deals',
        'filter' => ['type' => 'most_saved'],
        'color' => '#1abc9c',
        'icon' => '❤️',
        'description' => 'Most wishlisted and saved deals'
    ],
    [
        'filename' => 'deal-of-day.php',
        'title' => 'Deal of the Day',
        'filter' => ['type' => 'deal_of_day'],
        'color' => '#e74c3c',
        'icon' => '🌟',
        'description' => 'Featured deal of the day with massive discount'
    ],
    [
        'filename' => 'last-chance.php',
        'title' => 'Last Chance - Ending Soon',
        'filter' => ['type' => 'ending_soon'],
        'color' => '#c0392b',
        'icon' => '⏰',
        'description' => 'Deals ending soon - grab before expiry'
    ],
    [
        'filename' => 'buy-1-get-1.php',
        'title' => 'Buy 1 Get 1 Free Offers',
        'filter' => ['type' => 'bogo'],
        'color' => '#2ecc71',
        'icon' => '🎁',
        'description' => 'Buy one get one free deals'
    ],
    [
        'filename' => 'gift-ideas.php',
        'title' => 'Gift Ideas & Special Offers',
        'filter' => ['type' => 'gifts'],
        'color' => '#e91e63',
        'icon' => '🎀',
        'description' => 'Perfect gift ideas at best prices'
    ],
    [
        'filename' => 'eco-friendly.php',
        'title' => 'Eco-Friendly Products',
        'filter' => ['type' => 'eco'],
        'color' => '#27ae60',
        'icon' => '🌱',
        'description' => 'Environment-friendly products and deals'
    ],
    [
        'filename' => 'handmade-deals.php',
        'title' => 'Handmade & Unique Products',
        'filter' => ['type' => 'handmade'],
        'color' => '#d35400',
        'icon' => '✋',
        'description' => 'Handcrafted and unique product deals'
    ],
    [
        'filename' => 'local-sellers.php',
        'title' => 'Local Sellers & Support',
        'filter' => ['type' => 'local'],
        'color' => '#3498db',
        'icon' => '🏪',
        'description' => 'Support local sellers with great deals'
    ]
];

echo "Total Pages to Generate: " . count($pages) . "\n\n";

foreach ($pages as $index => $pageConfig) {
    echo ($index + 1) . ". Creating: " . $pageConfig['filename'] . " - " . $pageConfig['title'] . "\n";
}

echo "\n✅ Page configuration ready. " . count($pages) . " pages will be generated.\n";
echo "Run generate-pages-execute.php to create all files.\n";
?>