<?php
/**
 * All Deals Pages - Complete Directory
 * Navigation hub for all 54 specialized deal pages
 */

require_once 'includes/config.php';

$pageTitle = "All Deals Pages - Browse 54+ Specialized Deal Collections";
$metaDescription = "Explore 54+ specialized deal pages including budget deals, hot discounts, category-specific offers, and exclusive collections. Find your perfect deal!";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <m                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo SITE_URL; ?>" class="text-white-50">Home</a></li>
                        <li><a href="<?php echo SITE_URL; ?>" class="text-white-50">All Deals</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/hot-deals" class="text-white-50">Hot Deals</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/all-pages" class="text-white-50">Browse All Pages</a></li>
                    </ul>
                </div>"viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <meta name="description" content="<?php echo $metaDescription; ?>">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link href="<?php echo SITE_URL; ?>/assets/css/style.css" rel="stylesheet">
    
    <style>
        /* Navigation Styles */
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            border-radius: 8px;
            padding: 10px 0;
            margin-top: 8px;
            min-width: 250px;
        }
        
        .dropdown-item {
            padding: 10px 20px;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }
        
        .dropdown-item:hover {
            background-color: #f8f9ff;
            color: #2874f0;
            padding-left: 25px;
        }
        
        .dropdown-header {
            color: #2874f0;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 10px 20px 5px;
        }
        
        .nav-link {
            font-weight: 500;
            padding: 8px 16px !important;
            transition: all 0.2s ease;
        }
        
        .nav-link:hover {
            color: #2874f0 !important;
            background-color: rgba(40, 116, 240, 0.08);
            border-radius: 6px;
        }
        
        .nav-link i {
            margin-right: 4px;
            font-size: 1.1em;
        }
        
        .page-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 80px 0;
            margin-bottom: 50px;
        }
        .category-section {
            margin-bottom: 50px;
        }
        .category-header {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
        }
        .page-card {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            height: 100%;
        }
        .page-card:hover {
            border-color: #667eea;
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);
        }
        .page-icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        .page-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 10px;
            color: #2c3e50;
        }
        .page-description {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }
        .page-link {
            text-decoration: none;
            color: inherit;
        }
        .stats-box {
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .quick-search {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.1);
            margin-bottom: 40px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="<?php echo SITE_URL; ?>" style="color: #2874f0;">
                <img src="https://www.thiyagi.com/nt.png" alt="<?php echo SITE_NAME; ?>" height="40" class="me-2">
                <span class="fs-4"><?php echo SITE_NAME; ?></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <!-- Home -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo SITE_URL; ?>">
                            <i class="bi bi-house-door"></i> Home
                        </a>
                    </li>
                    
                    <!-- Popular Deals Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarPopular" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-fire"></i> Popular Deals
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarPopular">
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/hot-deals">🔥 Hot Deals (40%+ OFF)</a></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/todays-deals">📅 Today's Deals</a></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/flash-sale">⚡ Flash Sale</a></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/deal-of-day">🎯 Deal of the Day</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/trending">📈 Trending Now</a></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/best-sellers">⭐ Best Sellers</a></li>
                        </ul>
                    </li>
                    
                    <!-- Price Range Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarPrice" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-currency-rupee"></i> By Price
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarPrice">
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/deals-under-500">💰 Under ₹500</a></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/deals-500-1000">💵 ₹500 - ₹1000</a></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/deals-under-1000">💸 Under ₹1000</a></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/deals-1000-5000">💴 ₹1000 - ₹5000</a></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/deals-under-2000">💷 Under ₹2000</a></li>
                        </ul>
                    </li>
                    
                    <!-- Categories Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarCategories" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-grid"></i> Categories
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarCategories">
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/electronics-deals">📱 Electronics</a></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/fashion-deals">👗 Fashion</a></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/home-kitchen">🏠 Home & Kitchen</a></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/beauty-deals">💄 Beauty & Personal Care</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/sports-fitness">⚽ Sports & Fitness</a></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/toys-kids">🧸 Toys & Kids</a></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/books-media">📚 Books & Media</a></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/automotive">🚗 Automotive</a></li>
                        </ul>
                    </li>
                    
                    <!-- More Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarMore" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots"></i> More
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarMore">
                            <li><h6 class="dropdown-header">Stores</h6></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/amazon-deals">🛒 Amazon Deals</a></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/flipkart-deals">🛒 Flipkart Deals</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><h6 class="dropdown-header">Special</h6></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/buy-1-get-1">🎁 Buy 1 Get 1</a></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/free-delivery">🚚 Free Delivery</a></li>
                            <li><a class="dropdown-item" href="<?php echo SITE_URL; ?>/festival-sale">🎊 Festival Sale</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item fw-bold text-primary" href="<?php echo SITE_URL; ?>/all-pages">📋 All Deals Pages</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Hero Section -->
    <div class="page-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-3 mb-3">🎯 All Deals Pages</h1>
                    <p class="lead mb-4">Browse through 54+ specialized deal collections tailored for every shopping need</p>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>" style="color: white;">Home</a></li>
                            <li class="breadcrumb-item active" style="color: rgba(255,255,255,0.8);">All Deals</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-4">
                    <div class="stats-box">
                        <h2 class="mb-0">54+</h2>
                        <p class="mb-2">Specialized Pages</p>
                        <hr style="border-color: rgba(255,255,255,0.3); margin: 15px 0;">
                        <h3 class="mb-0">1000+</h3>
                        <p class="mb-0">Daily Deals</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container mb-5">
        <!-- Quick Search -->
        <div class="quick-search">
            <h3 class="text-center mb-4">🔍 Quick Search</h3>
            <div class="input-group input-group-lg">
                <span class="input-group-text">🔎</span>
                <input type="text" class="form-control" id="pageSearch" placeholder="Search for deals, categories, or features...">
            </div>
            <div class="text-center mt-3">
                <small class="text-muted">Try: "under 500", "amazon", "electronics", "50% off", etc.</small>
            </div>
        </div>
        
        <!-- Price-Based Pages -->
        <div class="category-section">
            <div class="category-header">
                <h2 class="mb-0">💰 Price-Based Deals (7 Pages)</h2>
                <small>Find deals by your budget</small>
            </div>
            <div class="row">
                <?php 
                $pricePages = [
                    ['icon' => '💰', 'title' => 'Deals Under ₹500', 'url' => 'deals-under-500.php', 'desc' => 'Budget-friendly deals under ₹500'],
                    ['icon' => '💵', 'title' => 'Deals Under ₹1000', 'url' => 'deals-under-1000.php', 'desc' => 'Best value deals under ₹1000'],
                    ['icon' => '💸', 'title' => 'Deals Under ₹2000', 'url' => 'deals-under-2000.php', 'desc' => 'Premium quality under ₹2000'],
                    ['icon' => '💳', 'title' => 'Deals ₹500-1000', 'url' => 'deals-500-1000.php', 'desc' => 'Mid-range value deals'],
                    ['icon' => '💎', 'title' => 'Deals ₹1000-5000', 'url' => 'deals-1000-5000.php', 'desc' => 'Quality products ₹1000-5000'],
                    ['icon' => '⭐', 'title' => 'Premium Deals', 'url' => 'premium-deals.php', 'desc' => 'Premium products ₹5000+'],
                    ['icon' => '👑', 'title' => 'Luxury Deals', 'url' => 'luxury-deals.php', 'desc' => 'Luxury products ₹10000+'],
                ];
                foreach ($pricePages as $page): ?>
                <div class="col-md-4 col-lg-3">
                    <a href="<?php echo $page['url']; ?>" class="page-link">
                        <div class="page-card">
                            <div class="page-icon"><?php echo $page['icon']; ?></div>
                            <div class="page-title"><?php echo $page['title']; ?></div>
                            <div class="page-description"><?php echo $page['desc']; ?></div>
                            <button class="btn btn-sm btn-outline-primary">Browse Deals →</button>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Discount-Based Pages -->
        <div class="category-section">
            <div class="category-header" style="background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);">
                <h2 class="mb-0">🔥 Discount-Based Deals (6 Pages)</h2>
                <small>Maximum savings guaranteed</small>
            </div>
            <div class="row">
                <?php 
                $discountPages = [
                    ['icon' => '🔥', 'title' => 'Hot Deals (40%+ OFF)', 'url' => 'hot-deals.php', 'desc' => 'Minimum 40% discount deals'],
                    ['icon' => '💥', 'title' => 'Super Saver (50%+ OFF)', 'url' => 'super-saver.php', 'desc' => 'Incredible 50%+ discounts'],
                    ['icon' => '🎯', 'title' => 'Mega Discounts (60%+ OFF)', 'url' => 'mega-discounts.php', 'desc' => 'Massive 60%+ savings'],
                    ['icon' => '⚡', 'title' => 'Minimum 25% OFF', 'url' => 'deals-25-percent-off.php', 'desc' => 'Great deals with 25%+ off'],
                    ['icon' => '💫', 'title' => 'Minimum 30% OFF', 'url' => 'deals-30-percent-off.php', 'desc' => 'Exciting 30%+ discounts'],
                    ['icon' => '💣', 'title' => 'Clearance (70%+ OFF)', 'url' => 'clearance-sale.php', 'desc' => 'Ultimate 70%+ clearance'],
                ];
                foreach ($discountPages as $page): ?>
                <div class="col-md-4 col-lg-3">
                    <a href="<?php echo $page['url']; ?>" class="page-link">
                        <div class="page-card">
                            <div class="page-icon"><?php echo $page['icon']; ?></div>
                            <div class="page-title"><?php echo $page['title']; ?></div>
                            <div class="page-description"><?php echo $page['desc']; ?></div>
                            <button class="btn btn-sm btn-outline-danger">Grab Deals →</button>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Store-Specific Pages -->
        <div class="category-section">
            <div class="category-header" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <h2 class="mb-0">🛒 Store-Specific Deals (2 Pages)</h2>
                <small>Shop by your favorite store</small>
            </div>
            <div class="row">
                <?php 
                $storePages = [
                    ['icon' => '📦', 'title' => 'Amazon Deals', 'url' => 'amazon-deals.php', 'desc' => 'Exclusive Amazon offers (~42 products)'],
                    ['icon' => '🛍️', 'title' => 'Flipkart Deals', 'url' => 'flipkart-deals.php', 'desc' => 'Best Flipkart deals (~8 products)'],
                ];
                foreach ($storePages as $page): ?>
                <div class="col-md-6">
                    <a href="<?php echo $page['url']; ?>" class="page-link">
                        <div class="page-card">
                            <div class="page-icon"><?php echo $page['icon']; ?></div>
                            <div class="page-title"><?php echo $page['title']; ?></div>
                            <div class="page-description"><?php echo $page['desc']; ?></div>
                            <button class="btn btn-sm btn-outline-info">Shop Now →</button>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Category Pages -->
        <div class="category-section">
            <div class="category-header" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);">
                <h2 class="mb-0">🏷️ Category-Wise Deals (10 Pages)</h2>
                <small>Browse by product category</small>
            </div>
            <div class="row">
                <?php 
                $categoryPages = [
                    ['icon' => '📱', 'title' => 'Electronics', 'url' => 'electronics-deals.php', 'desc' => 'Gadgets & electronics'],
                    ['icon' => '👗', 'title' => 'Fashion', 'url' => 'fashion-deals.php', 'desc' => 'Clothing & accessories'],
                    ['icon' => '🏠', 'title' => 'Home & Kitchen', 'url' => 'home-kitchen.php', 'desc' => 'Home essentials'],
                    ['icon' => '💄', 'title' => 'Beauty', 'url' => 'beauty-deals.php', 'desc' => 'Beauty & personal care'],
                    ['icon' => '⚽', 'title' => 'Sports', 'url' => 'sports-fitness.php', 'desc' => 'Sports & fitness gear'],
                    ['icon' => '📚', 'title' => 'Books & Media', 'url' => 'books-media.php', 'desc' => 'Books, music, movies'],
                    ['icon' => '🧸', 'title' => 'Toys & Kids', 'url' => 'toys-kids.php', 'desc' => 'Kids products'],
                    ['icon' => '🚗', 'title' => 'Automotive', 'url' => 'automotive.php', 'desc' => 'Car & bike accessories'],
                    ['icon' => '🏥', 'title' => 'Health', 'url' => 'health-wellness.php', 'desc' => 'Health & wellness'],
                    ['icon' => '🐾', 'title' => 'Pet Supplies', 'url' => 'pet-supplies.php', 'desc' => 'Pet care products'],
                ];
                foreach ($categoryPages as $page): ?>
                <div class="col-md-4 col-lg-3">
                    <a href="<?php echo $page['url']; ?>" class="page-link">
                        <div class="page-card">
                            <div class="page-icon"><?php echo $page['icon']; ?></div>
                            <div class="page-title"><?php echo $page['title']; ?></div>
                            <div class="page-description"><?php echo $page['desc']; ?></div>
                            <button class="btn btn-sm btn-outline-success">Explore →</button>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Time-Based & Event Pages -->
        <div class="category-section">
            <div class="category-header" style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);">
                <h2 class="mb-0">📅 Time-Based & Event Deals (8 Pages)</h2>
                <small>Special occasion offers</small>
            </div>
            <div class="row">
                <?php 
                $timePages = [
                    ['icon' => '📅', 'title' => "Today's Deals", 'url' => 'todays-deals.php', 'desc' => 'Fresh deals added today'],
                    ['icon' => '📆', 'title' => 'Weekly Deals', 'url' => 'weekly-deals.php', 'desc' => 'This week\'s best'],
                    ['icon' => '🎉', 'title' => 'Weekend Special', 'url' => 'weekend-special.php', 'desc' => 'Weekend exclusive'],
                    ['icon' => '⚡', 'title' => 'Flash Sale', 'url' => 'flash-sale.php', 'desc' => 'Limited time only'],
                    ['icon' => '🎆', 'title' => 'Festival Sale', 'url' => 'festival-sale.php', 'desc' => 'Festival special offers'],
                    ['icon' => '📉', 'title' => 'Month End Sale', 'url' => 'month-end-sale.php', 'desc' => 'Month end clearance'],
                    ['icon' => '💰', 'title' => 'Payday Special', 'url' => 'payday-special.php', 'desc' => 'Payday shopping deals'],
                    ['icon' => '🌙', 'title' => 'Midnight Deals', 'url' => 'midnight-deals.php', 'desc' => 'Night special prices'],
                ];
                foreach ($timePages as $page): ?>
                <div class="col-md-4 col-lg-3">
                    <a href="<?php echo $page['url']; ?>" class="page-link">
                        <div class="page-card">
                            <div class="page-icon"><?php echo $page['icon']; ?></div>
                            <div class="page-title"><?php echo $page['title']; ?></div>
                            <div class="page-description"><?php echo $page['desc']; ?></div>
                            <button class="btn btn-sm btn-outline-warning">Check Now →</button>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Special Collections -->
        <div class="category-section">
            <div class="category-header" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <h2 class="mb-0">⭐ Special Collections (21 Pages)</h2>
                <small>Curated deals collections</small>
            </div>
            <div class="row">
                <?php 
                $specialPages = [
                    ['icon' => '🆕', 'title' => 'New Arrivals', 'url' => 'new-arrivals.php'],
                    ['icon' => '📈', 'title' => 'Trending Now', 'url' => 'trending.php'],
                    ['icon' => '🏆', 'title' => 'Best Sellers', 'url' => 'best-sellers.php'],
                    ['icon' => '✨', 'title' => "Editor's Choice", 'url' => 'editors-choice.php'],
                    ['icon' => '⚠️', 'title' => 'Limited Stock', 'url' => 'limited-stock.php'],
                    ['icon' => '🚚', 'title' => 'Free Delivery', 'url' => 'free-delivery.php'],
                    ['icon' => '💸', 'title' => 'Maximum Savings', 'url' => 'maximum-savings.php'],
                    ['icon' => '💎', 'title' => 'Best Value', 'url' => 'best-value.php'],
                    ['icon' => '🎁', 'title' => 'Combo Deals', 'url' => 'combo-deals.php'],
                    ['icon' => '📉', 'title' => 'Price Drop Alert', 'url' => 'price-drop-alert.php'],
                    ['icon' => '🎯', 'title' => 'Lowest Prices', 'url' => 'lowest-prices.php'],
                    ['icon' => '🎁', 'title' => 'Recommended', 'url' => 'recommended-deals.php'],
                    ['icon' => '⭐', 'title' => 'Top Rated', 'url' => 'top-rated.php'],
                    ['icon' => '❤️', 'title' => 'Most Saved', 'url' => 'most-saved.php'],
                    ['icon' => '🌟', 'title' => 'Deal of the Day', 'url' => 'deal-of-day.php'],
                    ['icon' => '⏰', 'title' => 'Last Chance', 'url' => 'last-chance.php'],
                    ['icon' => '🎁', 'title' => 'Buy 1 Get 1', 'url' => 'buy-1-get-1.php'],
                    ['icon' => '🎀', 'title' => 'Gift Ideas', 'url' => 'gift-ideas.php'],
                    ['icon' => '🌱', 'title' => 'Eco-Friendly', 'url' => 'eco-friendly.php'],
                    ['icon' => '✋', 'title' => 'Handmade', 'url' => 'handmade-deals.php'],
                    ['icon' => '🏪', 'title' => 'Local Sellers', 'url' => 'local-sellers.php'],
                ];
                foreach ($specialPages as $page): ?>
                <div class="col-md-4 col-lg-3">
                    <a href="<?php echo $page['url']; ?>" class="page-link">
                        <div class="page-card">
                            <div class="page-icon"><?php echo $page['icon']; ?></div>
                            <div class="page-title"><?php echo $page['title']; ?></div>
                            <button class="btn btn-sm btn-outline-secondary">View →</button>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="bg-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><?php echo SITE_NAME; ?></h5>
                    <p>Your trusted destination for best deals and offers online.</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo SITE_URL; ?>" class="text-white-50">Home</a></li>
                        <li><a href="<?php echo SITE_URL; ?>" class="text-white-50">All Deals</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/shop/hot-deals.php" class="text-white-50">Hot Deals</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/shop/all-pages.php" class="text-white-50">Browse All Pages</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact</h5>
                    <p class="text-white-50">Email: support@thiyagi.com<br>© <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Quick search functionality
        document.getElementById('pageSearch').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const allCards = document.querySelectorAll('.page-card');
            
            allCards.forEach(card => {
                const title = card.querySelector('.page-title').textContent.toLowerCase();
                const desc = card.querySelector('.page-description')?.textContent.toLowerCase() || '';
                
                if (title.includes(searchTerm) || desc.includes(searchTerm)) {
                    card.closest('.col-md-4, .col-md-6, .col-lg-3').style.display = '';
                } else {
                    card.closest('.col-md-4, .col-md-6, .col-lg-3').style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>