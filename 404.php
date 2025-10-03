<?php
/**
 * Custom 404 Error Page
 * User-friendly page not found error with helpful navigation
 */

require_once 'includes/config.php';
require_once 'includes/functions.php';

// Set HTTP 404 status
http_response_code(404);

// SEO and page metadata
$pageTitle = "Page Not Found - 404 Error";
$pageDescription = "Sorry, the page you're looking for doesn't exist. Browse our amazing deals and offers instead.";
$pageKeywords = "404 error, page not found, deals, offers, shopping";

// Get the requested URL for logging/debugging
$requestedUrl = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : 'Unknown';

// Include header
include 'includes/header.php';
?>

<style>
    .error-404-container {
        min-height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        text-align: center;
    }
    
    .error-404-content {
        max-width: 600px;
        animation: fadeInUp 0.6s ease-out;
    }
    
    .error-404-number {
        font-size: 150px;
        font-weight: 900;
        line-height: 1;
        margin-bottom: 20px;
        text-shadow: 4px 4px 8px rgba(0,0,0,0.3);
        animation: bounce 2s infinite;
    }
    
    .error-404-title {
        font-size: 36px;
        font-weight: 700;
        margin-bottom: 20px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }
    
    .error-404-message {
        font-size: 18px;
        margin-bottom: 40px;
        opacity: 0.9;
        line-height: 1.6;
    }
    
    .error-404-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
        flex-wrap: wrap;
        margin-bottom: 40px;
    }
    
    .error-404-btn {
        padding: 15px 30px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 600;
        font-size: 16px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    
    .btn-primary-404 {
        background: white;
        color: #667eea;
    }
    
    .btn-primary-404:hover {
        background: #f8f9fa;
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        color: #667eea;
    }
    
    .btn-secondary-404 {
        background: rgba(255,255,255,0.2);
        color: white;
        border: 2px solid white;
    }
    
    .btn-secondary-404:hover {
        background: rgba(255,255,255,0.3);
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.3);
        color: white;
    }
    
    .popular-pages {
        background: white;
        color: #333;
        padding: 60px 20px;
    }
    
    .popular-pages h2 {
        text-align: center;
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 40px;
        color: #667eea;
    }
    
    .pages-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .page-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 30px;
        border-radius: 15px;
        text-align: center;
        text-decoration: none;
        color: white;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .page-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        color: white;
    }
    
    .page-card-icon {
        font-size: 48px;
        margin-bottom: 15px;
    }
    
    .page-card-title {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 10px;
    }
    
    .page-card-description {
        font-size: 14px;
        opacity: 0.9;
    }
    
    .search-box-404 {
        max-width: 500px;
        margin: 0 auto 30px;
        position: relative;
    }
    
    .search-box-404 input {
        width: 100%;
        padding: 15px 50px 15px 20px;
        border-radius: 30px;
        border: 2px solid white;
        font-size: 16px;
        background: rgba(255,255,255,0.9);
    }
    
    .search-box-404 button {
        position: absolute;
        right: 5px;
        top: 50%;
        transform: translateY(-50%);
        background: #667eea;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 25px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .search-box-404 button:hover {
        background: #764ba2;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }
    
    @media (max-width: 768px) {
        .error-404-number {
            font-size: 100px;
        }
        
        .error-404-title {
            font-size: 28px;
        }
        
        .error-404-message {
            font-size: 16px;
        }
        
        .error-404-actions {
            flex-direction: column;
        }
        
        .error-404-btn {
            width: 100%;
            justify-content: center;
        }
        
        .pages-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- 404 Error Section -->
<div class="error-404-container">
    <div class="error-404-content">
        <div class="error-404-number">404</div>
        <h1 class="error-404-title">Oops! Page Not Found</h1>
        <p class="error-404-message">
            The page you're looking for seems to have wandered off. 
            Don't worry, we have plenty of amazing deals waiting for you!
        </p>
        
        <!-- Search Box -->
        <div class="search-box-404">
            <form action="<?php echo SITE_URL; ?>" method="get">
                <input type="text" name="search" placeholder="Search for deals..." required>
                <button type="submit">🔍 Search</button>
            </form>
        </div>
        
        <!-- Action Buttons -->
        <div class="error-404-actions">
            <a href="<?php echo SITE_URL; ?>" class="error-404-btn btn-primary-404">
                🏠 Go Home
            </a>
            <a href="<?php echo SITE_URL; ?>/all-pages" class="error-404-btn btn-secondary-404">
                📑 Browse All Pages
            </a>
        </div>
        
        <p style="font-size: 14px; opacity: 0.7; margin-top: 20px;">
            Error Code: 404 | Requested: <?php echo htmlspecialchars(basename($requestedUrl)); ?>
        </p>
    </div>
</div>

<!-- Popular Pages Section -->
<div class="popular-pages">
    <div class="container">
        <h2>🔥 Popular Pages You Might Like</h2>
        
        <div class="pages-grid">
            <a href="<?php echo SITE_URL; ?>/todays-deals" class="page-card">
                <div class="page-card-icon">🎯</div>
                <div class="page-card-title">Today's Deals</div>
                <div class="page-card-description">Fresh deals added today</div>
            </a>
            
            <a href="<?php echo SITE_URL; ?>/hot-deals" class="page-card">
                <div class="page-card-icon">🔥</div>
                <div class="page-card-title">Hot Deals</div>
                <div class="page-card-description">40% OFF or more</div>
            </a>
            
            <a href="<?php echo SITE_URL; ?>/trending" class="page-card">
                <div class="page-card-icon">📈</div>
                <div class="page-card-title">Trending Now</div>
                <div class="page-card-description">Most popular products</div>
            </a>
            
            <a href="<?php echo SITE_URL; ?>/flash-sale" class="page-card">
                <div class="page-card-icon">⚡</div>
                <div class="page-card-title">Flash Sale</div>
                <div class="page-card-description">Limited time offers</div>
            </a>
            
            <a href="<?php echo SITE_URL; ?>/deals-under-500" class="page-card">
                <div class="page-card-icon">💰</div>
                <div class="page-card-title">Under ₹500</div>
                <div class="page-card-description">Budget-friendly deals</div>
            </a>
            
            <a href="<?php echo SITE_URL; ?>/best-value" class="page-card">
                <div class="page-card-icon">⭐</div>
                <div class="page-card-title">Best Value</div>
                <div class="page-card-description">Maximum savings</div>
            </a>
            
            <a href="<?php echo SITE_URL; ?>/amazon-deals" class="page-card">
                <div class="page-card-icon">📦</div>
                <div class="page-card-title">Amazon Deals</div>
                <div class="page-card-description">Exclusive Amazon offers</div>
            </a>
            
            <a href="<?php echo SITE_URL; ?>/flipkart-deals" class="page-card">
                <div class="page-card-icon">🛒</div>
                <div class="page-card-title">Flipkart Deals</div>
                <div class="page-card-description">Best Flipkart prices</div>
            </a>
        </div>
    </div>
</div>

<!-- Quick Links -->
<div class="container" style="padding: 40px 20px; text-align: center;">
    <h3 style="margin-bottom: 20px; color: #667eea;">Quick Links</h3>
    <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
        <a href="<?php echo SITE_URL; ?>" style="color: #667eea; text-decoration: none; padding: 10px 20px; border: 2px solid #667eea; border-radius: 25px; transition: all 0.3s;">Home</a>
        <a href="<?php echo SITE_URL; ?>/all-pages" style="color: #667eea; text-decoration: none; padding: 10px 20px; border: 2px solid #667eea; border-radius: 25px; transition: all 0.3s;">All Pages</a>
        <a href="<?php echo SITE_URL; ?>/hot-deals" style="color: #667eea; text-decoration: none; padding: 10px 20px; border: 2px solid #667eea; border-radius: 25px; transition: all 0.3s;">Hot Deals</a>
        <a href="https://thiyagi.com" style="color: #667eea; text-decoration: none; padding: 10px 20px; border: 2px solid #667eea; border-radius: 25px; transition: all 0.3s;">Contact</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>