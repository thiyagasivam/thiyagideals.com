<?php
/**
 * All Deals Pages - Complete Directory
 * Navigation hub for all 54 specialized deal pages
 */

require_once 'includes/config.php';

// Canonical URL for SEO
$canonicalUrl = SITE_URL . '/all-pages';

$pageTitle = "All Deals Pages - Browse 150+ Specialized Deal Collections";
$metaDescription = "Explore 150+ specialized deal pages including budget deals, hot discounts, festival offers, category-specific deals, and exclusive collections. Find your perfect deal!";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    <p class="lead mb-4">Browse through 150+ specialized deal collections tailored for every shopping need</p>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>" style="color: white;">Home</a></li>
                            <li class="breadcrumb-item active" style="color: rgba(255,255,255,0.8);">All Deals</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-4">
                    <div class="stats-box">
                        <h2 class="mb-0">150+</h2>
                        <p class="mb-2">Specialized Pages</p>
                        <hr style="border-color: rgba(255,255,255,0.3); margin: 15px 0;">
                        <h3 class="mb-0">2000+</h3>
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
        
        <!-- Price-Based Pages - PHASE 3 -->
        <div class="category-section">
            <div class="category-header">
                <h2 class="mb-0">💰 Price-Based Deals (12 Pages)</h2>
                <small>Find deals by your budget - All price ranges covered</small>
            </div>
            <div class="row">
                <?php 
                $pricePages = [
                    ['icon' => '💰', 'title' => 'Under ₹299', 'url' => 'deals-under-299', 'desc' => 'Ultra-budget deals under ₹299'],
                    ['icon' => '💵', 'title' => 'Under ₹500', 'url' => 'deals-under-500', 'desc' => 'Budget-friendly under ₹500'],
                    ['icon' => '�', 'title' => 'Under ₹999', 'url' => 'deals-under-999', 'desc' => 'Value deals under ₹999'],
                    ['icon' => '💳', 'title' => 'Under ₹1000', 'url' => 'deals-under-1000', 'desc' => 'Best value under ₹1000'],
                    ['icon' => '�', 'title' => 'Under ₹2000', 'url' => 'deals-under-2000', 'desc' => 'Quality under ₹2000'],
                    ['icon' => '🎯', 'title' => 'Under ₹5000', 'url' => 'deals-under-5000', 'desc' => 'Premium under ₹5000'],
                    ['icon' => '⭐', 'title' => '₹500-₹1000', 'url' => 'deals-500-1000', 'desc' => 'Mid-range value deals'],
                    ['icon' => '💎', 'title' => '₹1000-₹5000', 'url' => 'deals-1000-5000', 'desc' => 'Quality products ₹1K-5K'],
                    ['icon' => '👑', 'title' => '₹5000-₹10000', 'url' => 'deals-5000-10000', 'desc' => 'Premium range ₹5K-10K'],
                    ['icon' => '💎', 'title' => '₹10000-₹50000', 'url' => 'deals-10000-50000', 'desc' => 'Luxury range ₹10K-50K'],
                    ['icon' => '🌟', 'title' => '₹50000+', 'url' => 'deals-50000-plus', 'desc' => 'Ultra-luxury above ₹50K'],
                    ['icon' => '🎁', 'title' => 'Budget Friendly', 'url' => 'budget-friendly-deals', 'desc' => 'Best affordable options'],
                ];
                foreach ($pricePages as $page): ?>
                <div class="col-md-4 col-lg-3">
                    <a href="<?php echo SITE_URL; ?>/<?php echo $page['url']; ?>" class="page-link">
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
        
        <!-- Discount-Based Pages - PHASE 4 -->
        <div class="category-section">
            <div class="category-header" style="background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);">
                <h2 class="mb-0">🔥 Discount-Based Deals (14 Pages)</h2>
                <small>Maximum savings guaranteed - All discount ranges</small>
            </div>
            <div class="row">
                <?php 
                $discountPages = [
                    ['icon' => '�', 'title' => '10% OFF', 'url' => 'deals-10-percent-off', 'desc' => '10-19% discount deals'],
                    ['icon' => '⚡', 'title' => '25% OFF+', 'url' => 'deals-25-percent-off', 'desc' => 'Minimum 25% discounts'],
                    ['icon' => '�', 'title' => '30% OFF+', 'url' => 'deals-30-percent-off', 'desc' => 'Minimum 30% savings'],
                    ['icon' => '🎯', 'title' => '40% OFF', 'url' => 'deals-40-percent-off', 'desc' => '40-49% discount range'],
                    ['icon' => '🔥', 'title' => '50% OFF', 'url' => 'deals-50-percent-off', 'desc' => '50-59% mega savings'],
                    ['icon' => '💥', 'title' => '60% OFF', 'url' => 'deals-60-percent-off', 'desc' => '60-69% huge discounts'],
                    ['icon' => '💣', 'title' => '70% OFF', 'url' => 'deals-70-percent-off', 'desc' => '70-74% massive savings'],
                    ['icon' => '⚡', 'title' => '75% OFF', 'url' => 'deals-75-percent-off', 'desc' => '75-79% incredible deals'],
                    ['icon' => '🌟', 'title' => '80% OFF', 'url' => 'deals-80-percent-off', 'desc' => '80-89% super savings'],
                    ['icon' => '�', 'title' => '90% OFF', 'url' => 'deals-90-percent-off', 'desc' => '90%+ ultra discounts'],
                    ['icon' => '🔥', 'title' => 'Hot Deals (40%+)', 'url' => 'hot-deals', 'desc' => 'Minimum 40% discount'],
                    ['icon' => '💥', 'title' => 'Super Saver (50%+)', 'url' => 'super-saver', 'desc' => 'Incredible 50%+ off'],
                    ['icon' => '🎯', 'title' => 'Mega Discounts (60%+)', 'url' => 'mega-discounts', 'desc' => 'Massive 60%+ savings'],
                    ['icon' => '💣', 'title' => 'Clearance (70%+)', 'url' => 'clearance-sale', 'desc' => 'Ultimate 70%+ clearance'],
                ];
                foreach ($discountPages as $page): ?>
                <div class="col-md-4 col-lg-3">
                    <a href="<?php echo SITE_URL; ?>/<?php echo $page['url']; ?>" class="page-link">
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
                    ['icon' => '📦', 'title' => 'Amazon Deals', 'url' => 'amazon-deals', 'desc' => 'Exclusive Amazon offers (~42 products)'],
                    ['icon' => '🛍️', 'title' => 'Flipkart Deals', 'url' => 'flipkart-deals', 'desc' => 'Best Flipkart deals (~8 products)'],
                ];
                foreach ($storePages as $page): ?>
                <div class="col-md-6">
                    <a href="<?php echo SITE_URL; ?>/<?php echo $page['url']; ?>" class="page-link">
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
                    ['icon' => '📱', 'title' => 'Electronics', 'url' => 'electronics-deals', 'desc' => 'Gadgets & electronics'],
                    ['icon' => '👗', 'title' => 'Fashion', 'url' => 'fashion-deals', 'desc' => 'Clothing & accessories'],
                    ['icon' => '🏠', 'title' => 'Home & Kitchen', 'url' => 'home-kitchen', 'desc' => 'Home essentials'],
                    ['icon' => '💄', 'title' => 'Beauty', 'url' => 'beauty-deals', 'desc' => 'Beauty & personal care'],
                    ['icon' => '⚽', 'title' => 'Sports', 'url' => 'sports-fitness', 'desc' => 'Sports & fitness gear'],
                    ['icon' => '📚', 'title' => 'Books & Media', 'url' => 'books-media', 'desc' => 'Books, music, movies'],
                    ['icon' => '🧸', 'title' => 'Toys & Kids', 'url' => 'toys-kids', 'desc' => 'Kids products'],
                    ['icon' => '🚗', 'title' => 'Automotive', 'url' => 'automotive', 'desc' => 'Car & bike accessories'],
                    ['icon' => '🏥', 'title' => 'Health', 'url' => 'health-wellness', 'desc' => 'Health & wellness'],
                    ['icon' => '🐾', 'title' => 'Pet Supplies', 'url' => 'pet-supplies', 'desc' => 'Pet care products'],
                ];
                foreach ($categoryPages as $page): ?>
                <div class="col-md-4 col-lg-3">
                    <a href="<?php echo SITE_URL; ?>/<?php echo $page['url']; ?>" class="page-link">
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
        
        <!-- Festival & Occasion Pages - PHASE 2 -->
        <div class="category-section">
            <div class="category-header" style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);">
                <h2 class="mb-0">🎉 Festival & Occasion Deals (17 Pages)</h2>
                <small>Seasonal and special occasion offers</small>
            </div>
            <div class="row">
                <?php 
                $festivalPages = [
                    ['icon' => '🪔', 'title' => 'Diwali Deals', 'url' => 'diwali-deals', 'desc' => 'Festival of Lights offers'],
                    ['icon' => '🎄', 'title' => 'Christmas Deals', 'url' => 'christmas-deals', 'desc' => 'Merry Christmas savings'],
                    ['icon' => '🛍️', 'title' => 'Black Friday', 'url' => 'black-friday-deals', 'desc' => 'Biggest sale of the year'],
                    ['icon' => '💻', 'title' => 'Cyber Monday', 'url' => 'cyber-monday-deals', 'desc' => 'Online shopping bonanza'],
                    ['icon' => '🎆', 'title' => 'New Year Sale', 'url' => 'new-year-sale', 'desc' => 'Start fresh with savings'],
                    ['icon' => '🎊', 'title' => 'Holi Offers', 'url' => 'holi-deals', 'desc' => 'Colorful festival deals'],
                    ['icon' => '🕌', 'title' => 'Ramadan Sale', 'url' => 'ramadan-deals', 'desc' => 'Holy month special'],
                    ['icon' => '🎁', 'title' => 'Raksha Bandhan', 'url' => 'rakhi-deals', 'desc' => 'Sibling love offers'],
                    ['icon' => '🙏', 'title' => 'Navratri Deals', 'url' => 'navratri-deals', 'desc' => 'Nine nights celebration'],
                    ['icon' => '🌸', 'title' => 'Pongal Sale', 'url' => 'pongal-deals', 'desc' => 'Harvest festival offers'],
                    ['icon' => '💝', 'title' => "Valentine's Day", 'url' => 'valentine-deals', 'desc' => 'Love & romance gifts'],
                    ['icon' => '🎓', 'title' => 'Back to School', 'url' => 'back-to-school-deals', 'desc' => 'School essentials'],
                    ['icon' => '🏫', 'title' => 'Back to College', 'url' => 'back-to-college-deals', 'desc' => 'College must-haves'],
                    ['icon' => '🛒', 'title' => 'Prime Day', 'url' => 'prime-day-deals', 'desc' => 'Exclusive Prime offers'],
                    ['icon' => '🎂', 'title' => 'Birthday Sale', 'url' => 'birthday-sale', 'desc' => 'Celebrate with savings'],
                    ['icon' => '💍', 'title' => 'Wedding Season', 'url' => 'wedding-season-deals', 'desc' => 'Wedding essentials'],
                    ['icon' => '�', 'title' => 'Home Decor Sale', 'url' => 'home-decor-deals', 'desc' => 'Beautify your home'],
                ];
                foreach ($festivalPages as $page): ?>
                <div class="col-md-4 col-lg-3">
                    <a href="<?php echo SITE_URL; ?>/<?php echo $page['url']; ?>" class="page-link">
                        <div class="page-card">
                            <div class="page-icon"><?php echo $page['icon']; ?></div>
                            <div class="page-title"><?php echo $page['title']; ?></div>
                            <div class="page-description"><?php echo $page['desc']; ?></div>
                            <button class="btn btn-sm btn-outline-warning">Shop Festival →</button>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Time-Based Pages -->
        <div class="category-section">
            <div class="category-header" style="background: linear-gradient(135deg, #fbc2eb 0%, #a6c1ee 100%);">
                <h2 class="mb-0">⏰ Time-Based Deals (8 Pages)</h2>
                <small>Shop by time and urgency</small>
            </div>
            <div class="row">
                <?php 
                $timePages = [
                    ['icon' => '📅', 'title' => "Today's Deals", 'url' => 'todays-deals', 'desc' => 'Fresh deals added today'],
                    ['icon' => '📆', 'title' => 'Weekly Deals', 'url' => 'weekly-deals', 'desc' => 'This week\'s best'],
                    ['icon' => '🎉', 'title' => 'Weekend Special', 'url' => 'weekend-special', 'desc' => 'Weekend exclusive'],
                    ['icon' => '⚡', 'title' => 'Flash Sale', 'url' => 'flash-sale', 'desc' => 'Limited time only'],
                    ['icon' => '📉', 'title' => 'Month End Sale', 'url' => 'month-end-sale', 'desc' => 'Month end clearance'],
                    ['icon' => '💰', 'title' => 'Payday Special', 'url' => 'payday-special', 'desc' => 'Payday shopping deals'],
                    ['icon' => '🌙', 'title' => 'Midnight Deals', 'url' => 'midnight-deals', 'desc' => 'Night special prices'],
                    ['icon' => '🌅', 'title' => 'Morning Deals', 'url' => 'morning-deals', 'desc' => 'Early bird offers'],
                ];
                foreach ($timePages as $page): ?>
                <div class="col-md-4 col-lg-3">
                    <a href="<?php echo SITE_URL; ?>/<?php echo $page['url']; ?>" class="page-link">
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
                    ['icon' => '🆕', 'title' => 'New Arrivals', 'url' => 'new-arrivals'],
                    ['icon' => '📈', 'title' => 'Trending Now', 'url' => 'trending'],
                    ['icon' => '🏆', 'title' => 'Best Sellers', 'url' => 'best-sellers'],
                    ['icon' => '✨', 'title' => "Editor's Choice", 'url' => 'editors-choice'],
                    ['icon' => '⚠️', 'title' => 'Limited Stock', 'url' => 'limited-stock'],
                    ['icon' => '🚚', 'title' => 'Free Delivery', 'url' => 'free-delivery'],
                    ['icon' => '💸', 'title' => 'Maximum Savings', 'url' => 'maximum-savings'],
                    ['icon' => '💎', 'title' => 'Best Value', 'url' => 'best-value'],
                    ['icon' => '🎁', 'title' => 'Combo Deals', 'url' => 'combo-deals'],
                    ['icon' => '📉', 'title' => 'Price Drop Alert', 'url' => 'price-drop-alert'],
                    ['icon' => '🎯', 'title' => 'Lowest Prices', 'url' => 'lowest-prices'],
                    ['icon' => '🎁', 'title' => 'Recommended', 'url' => 'recommended-deals'],
                    ['icon' => '⭐', 'title' => 'Top Rated', 'url' => 'top-rated'],
                    ['icon' => '❤️', 'title' => 'Most Saved', 'url' => 'most-saved'],
                    ['icon' => '🌟', 'title' => 'Deal of the Day', 'url' => 'deal-of-day'],
                    ['icon' => '⏰', 'title' => 'Last Chance', 'url' => 'last-chance'],
                    ['icon' => '🎁', 'title' => 'Buy 1 Get 1', 'url' => 'buy-1-get-1'],
                    ['icon' => '🎀', 'title' => 'Gift Ideas', 'url' => 'gift-ideas'],
                    ['icon' => '🌱', 'title' => 'Eco-Friendly', 'url' => 'eco-friendly'],
                    ['icon' => '✋', 'title' => 'Handmade', 'url' => 'handmade-deals'],
                    ['icon' => '🏪', 'title' => 'Local Sellers', 'url' => 'local-sellers'],
                ];
                foreach ($specialPages as $page): ?>
                <div class="col-md-4 col-lg-3">
                    <a href="<?php echo SITE_URL; ?>/<?php echo $page['url']; ?>" class="page-link">
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
        
        <!-- Audience-Based Pages - PHASE 5 -->
        <div class="category-section">
            <div class="category-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <h2 class="mb-0">👥 Audience-Based Deals (10 Pages)</h2>
                <small>Deals tailored for specific audiences</small>
            </div>
            <div class="row">
                <?php 
                $audiencePages = [
                    ['icon' => '👨', 'title' => 'Men Deals', 'url' => 'men-deals', 'desc' => 'Products for men'],
                    ['icon' => '👩', 'title' => 'Women Deals', 'url' => 'women-deals', 'desc' => 'Products for women'],
                    ['icon' => '👶', 'title' => 'Kids Deals', 'url' => 'kids-deals', 'desc' => 'Products for children'],
                    ['icon' => '🎓', 'title' => 'Students Deals', 'url' => 'students-deals', 'desc' => 'Student essentials'],
                    ['icon' => '👴', 'title' => 'Seniors Deals', 'url' => 'seniors-deals', 'desc' => 'Senior citizen friendly'],
                    ['icon' => '🎮', 'title' => 'Gaming Deals', 'url' => 'gaming-deals', 'desc' => 'Gaming products'],
                    ['icon' => '💪', 'title' => 'Fitness Deals', 'url' => 'fitness-deals', 'desc' => 'Fitness enthusiasts'],
                    ['icon' => '💼', 'title' => 'Professionals', 'url' => 'professionals-deals', 'desc' => 'Work essentials'],
                    ['icon' => '📷', 'title' => 'Photographers', 'url' => 'photographers-deals', 'desc' => 'Photography gear'],
                    ['icon' => '✈️', 'title' => 'Travelers', 'url' => 'travelers-deals', 'desc' => 'Travel essentials'],
                ];
                foreach ($audiencePages as $page): ?>
                <div class="col-md-4 col-lg-3">
                    <a href="<?php echo SITE_URL; ?>/<?php echo $page['url']; ?>" class="page-link">
                        <div class="page-card">
                            <div class="page-icon"><?php echo $page['icon']; ?></div>
                            <div class="page-title"><?php echo $page['title']; ?></div>
                            <div class="page-description"><?php echo $page['desc']; ?></div>
                            <button class="btn btn-sm btn-outline-primary">Explore →</button>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Quality-Based Pages - PHASE 5 -->
        <div class="category-section">
            <div class="category-header" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <h2 class="mb-0">⭐ Quality-Based Deals (10 Pages)</h2>
                <small>Premium quality verified deals</small>
            </div>
            <div class="row">
                <?php 
                $qualityPages = [
                    ['icon' => '✅', 'title' => 'Verified Sellers', 'url' => 'verified-sellers-deals', 'desc' => 'Trusted sellers only'],
                    ['icon' => '🏆', 'title' => 'Bestsellers', 'url' => 'bestsellers-deals', 'desc' => 'Top selling products'],
                    ['icon' => '⭐', 'title' => 'Highly Rated', 'url' => 'highly-rated-deals', 'desc' => '4+ star ratings'],
                    ['icon' => '🎖️', 'title' => 'Certified', 'url' => 'certified-products-deals', 'desc' => 'Certified products'],
                    ['icon' => '🆕', 'title' => 'Brand New', 'url' => 'brand-new-deals', 'desc' => 'Factory sealed'],
                    ['icon' => '🌍', 'title' => 'Imported', 'url' => 'imported-products-deals', 'desc' => 'International products'],
                    ['icon' => '🔥', 'title' => 'Trending', 'url' => 'trending-deals', 'desc' => 'Most popular now'],
                    ['icon' => '🏅', 'title' => 'Award Winning', 'url' => 'award-winning-deals', 'desc' => 'Award winners'],
                    ['icon' => '💎', 'title' => 'Exclusive', 'url' => 'exclusive-deals', 'desc' => 'Exclusive to us'],
                    ['icon' => '🛡️', 'title' => 'Guaranteed', 'url' => 'guaranteed-quality-deals', 'desc' => 'Quality assured'],
                ];
                foreach ($qualityPages as $page): ?>
                <div class="col-md-4 col-lg-3">
                    <a href="<?php echo SITE_URL; ?>/<?php echo $page['url']; ?>" class="page-link">
                        <div class="page-card">
                            <div class="page-icon"><?php echo $page['icon']; ?></div>
                            <div class="page-title"><?php echo $page['title']; ?></div>
                            <div class="page-description"><?php echo $page['desc']; ?></div>
                            <button class="btn btn-sm btn-outline-danger">View →</button>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Shopping Pattern Pages - PHASE 5 -->
        <div class="category-section">
            <div class="category-header" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <h2 class="mb-0">🛍️ Shopping Pattern Deals (10 Pages)</h2>
                <small>Shop based on your habits</small>
            </div>
            <div class="row">
                <?php 
                $patternPages = [
                    ['icon' => '🎉', 'title' => 'Weekend Deals', 'url' => 'weekend-deals', 'desc' => 'Weekend shoppers'],
                    ['icon' => '🌅', 'title' => 'Morning Deals', 'url' => 'morning-deals', 'desc' => 'Early bird offers'],
                    ['icon' => '🌙', 'title' => 'Night Deals', 'url' => 'night-deals', 'desc' => 'Late night shopping'],
                    ['icon' => '📦', 'title' => 'Bulk Deals', 'url' => 'bulk-deals', 'desc' => 'Buy in bulk, save more'],
                    ['icon' => '🔔', 'title' => 'Pre-Order', 'url' => 'pre-order-deals', 'desc' => 'Reserve upcoming items'],
                    ['icon' => '🔄', 'title' => 'Subscription', 'url' => 'subscription-deals', 'desc' => 'Subscribe & save'],
                    ['icon' => '🆕', 'title' => 'First Time Buyer', 'url' => 'first-time-buyer-deals', 'desc' => 'New customer offers'],
                    ['icon' => '♻️', 'title' => 'Repeat Purchase', 'url' => 'repeat-purchase-deals', 'desc' => 'Loyal customers'],
                    ['icon' => '📱', 'title' => 'App Exclusive', 'url' => 'app-exclusive-deals', 'desc' => 'Mobile app only'],
                    ['icon' => '❤️', 'title' => 'Wishlist Deals', 'url' => 'wishlist-deals', 'desc' => 'From your wishlist'],
                ];
                foreach ($patternPages as $page): ?>
                <div class="col-md-4 col-lg-3">
                    <a href="<?php echo SITE_URL; ?>/<?php echo $page['url']; ?>" class="page-link">
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
        
        <!-- Urgency-Based Pages - PHASE 5 -->
        <div class="category-section">
            <div class="category-header" style="background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);">
                <h2 class="mb-0">⚡ Urgency-Based Deals (8 Pages)</h2>
                <small>Limited time offers - Act fast!</small>
            </div>
            <div class="row">
                <?php 
                $urgencyPages = [
                    ['icon' => '⏰', 'title' => 'Ending Today', 'url' => 'ending-today-deals', 'desc' => 'Expires tonight'],
                    ['icon' => '🚨', 'title' => 'Last Few Hours', 'url' => 'last-few-hours-deals', 'desc' => 'Hurry, ending soon'],
                    ['icon' => '📉', 'title' => 'Stock Running Out', 'url' => 'stock-running-out-deals', 'desc' => 'Limited quantity'],
                    ['icon' => '🔥', 'title' => 'Almost Sold Out', 'url' => 'almost-sold-out-deals', 'desc' => 'Few items left'],
                    ['icon' => '⚡', 'title' => 'One Day Only', 'url' => 'one-day-only-deals', 'desc' => '24-hour flash sale'],
                    ['icon' => '📆', 'title' => 'This Week Only', 'url' => 'this-week-only-deals', 'desc' => 'Weekly specials'],
                    ['icon' => '🎯', 'title' => 'Grab Now', 'url' => 'grab-now-deals', 'desc' => 'Hot selling fast'],
                    ['icon' => '⚠️', 'title' => 'While Stocks Last', 'url' => 'while-stocks-last-deals', 'desc' => 'Till stocks last'],
                ];
                foreach ($urgencyPages as $page): ?>
                <div class="col-md-4 col-lg-3">
                    <a href="<?php echo SITE_URL; ?>/<?php echo $page['url']; ?>" class="page-link">
                        <div class="page-card">
                            <div class="page-icon"><?php echo $page['icon']; ?></div>
                            <div class="page-title"><?php echo $page['title']; ?></div>
                            <div class="page-description"><?php echo $page['desc']; ?></div>
                            <button class="btn btn-sm btn-outline-danger">Hurry →</button>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Delivery-Based Pages - PHASE 5 -->
        <div class="category-section">
            <div class="category-header" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <h2 class="mb-0">🚚 Delivery-Based Deals (8 Pages)</h2>
                <small>Fast & convenient delivery options</small>
            </div>
            <div class="row">
                <?php 
                $deliveryPages = [
                    ['icon' => '⚡', 'title' => 'Same Day Delivery', 'url' => 'same-day-delivery-deals', 'desc' => 'Get it today'],
                    ['icon' => '📦', 'title' => 'Next Day Delivery', 'url' => 'next-day-delivery-deals', 'desc' => 'Tomorrow delivery'],
                    ['icon' => '🚚', 'title' => 'Free Shipping', 'url' => 'free-shipping-deals', 'desc' => 'No delivery charges'],
                    ['icon' => '🚀', 'title' => 'Express Delivery', 'url' => 'express-delivery-deals', 'desc' => 'Super fast shipping'],
                    ['icon' => '👑', 'title' => 'Prime Eligible', 'url' => 'prime-eligible-deals', 'desc' => 'Prime benefits'],
                    ['icon' => '💳', 'title' => 'COD Available', 'url' => 'cod-available-deals', 'desc' => 'Cash on delivery'],
                    ['icon' => '🔄', 'title' => 'Easy Returns', 'url' => 'easy-returns-deals', 'desc' => 'Hassle-free returns'],
                    ['icon' => '💰', 'title' => 'No Cost EMI', 'url' => 'no-cost-emi-deals', 'desc' => 'Easy installments'],
                ];
                foreach ($deliveryPages as $page): ?>
                <div class="col-md-4 col-lg-3">
                    <a href="<?php echo SITE_URL; ?>/<?php echo $page['url']; ?>" class="page-link">
                        <div class="page-card">
                            <div class="page-icon"><?php echo $page['icon']; ?></div>
                            <div class="page-title"><?php echo $page['title']; ?></div>
                            <div class="page-description"><?php echo $page['desc']; ?></div>
                            <button class="btn btn-sm btn-outline-success">Order →</button>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Condition-Based Pages - PHASE 5 -->
        <div class="category-section">
            <div class="category-header" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <h2 class="mb-0">📦 Condition-Based Deals (6 Pages)</h2>
                <small>Quality products at great prices</small>
            </div>
            <div class="row">
                <?php 
                $conditionPages = [
                    ['icon' => '♻️', 'title' => 'Renewed Deals', 'url' => 'renewed-deals', 'desc' => 'Certified renewed'],
                    ['icon' => '🔧', 'title' => 'Refurbished', 'url' => 'refurbished-deals', 'desc' => 'Professionally restored'],
                    ['icon' => '📦', 'title' => 'Open Box', 'url' => 'open-box-deals', 'desc' => 'Opened but unused'],
                    ['icon' => '🏬', 'title' => 'Display Unit', 'url' => 'display-unit-deals', 'desc' => 'Store display models'],
                    ['icon' => '🛡️', 'title' => 'Extended Warranty', 'url' => 'warranty-extended-deals', 'desc' => 'Extra protection'],
                    ['icon' => '🏭', 'title' => 'Factory Seconds', 'url' => 'factory-seconds-deals', 'desc' => 'Minor imperfections'],
                ];
                foreach ($conditionPages as $page): ?>
                <div class="col-md-4 col-lg-3">
                    <a href="<?php echo SITE_URL; ?>/<?php echo $page['url']; ?>" class="page-link">
                        <div class="page-card">
                            <div class="page-icon"><?php echo $page['icon']; ?></div>
                            <div class="page-title"><?php echo $page['title']; ?></div>
                            <div class="page-description"><?php echo $page['desc']; ?></div>
                            <button class="btn btn-sm btn-outline-warning">Browse →</button>
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
                        <li><a href="<?php echo SITE_URL; ?>/hot-deals" class="text-white-50">Hot Deals</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/all-pages" class="text-white-50">Browse All Pages</a></li>
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