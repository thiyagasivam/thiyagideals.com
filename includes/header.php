<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : SITE_NAME; ?></title>
    <meta name="description" content="<?php echo isset($pageDescription) ? $pageDescription : 'Best deals and offers on various products in ' . date('Y'); ?>">
    
    <!-- SEO Meta Tags -->
    <?php if (isset($pageKeywords)): ?>
    <meta name="keywords" content="<?php echo $pageKeywords; ?>">
    <?php endif; ?>
    
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="googlebot" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1">
    <meta name="bingbot" content="index, follow">
    <meta name="author" content="<?php echo SITE_NAME; ?>">
    <meta name="language" content="English">
    <meta name="distribution" content="global">
    <meta name="rating" content="general">
    <meta name="revisit-after" content="1 days">
    <meta name="generator" content="Custom PHP E-commerce">
    <meta name="copyright" content="<?php echo SITE_NAME . ' ' . date('Y'); ?>">
    <meta name="theme-color" content="#2874f0">
    <meta name="msapplication-TileColor" content="#ff9f00">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="format-detection" content="telephone=no">
    
    <!-- Geographic SEO -->
    <meta name="geo.region" content="IN">
    <meta name="geo.country" content="India">
    <meta name="ICBM" content="13.0827, 80.2707">
    <meta name="geo.position" content="13.0827;80.2707">
    
    <!-- Business Information -->
    <?php if (isset($product)): ?>
    <meta name="product" content="<?php echo sanitizeOutput($product['product_name']); ?>">
    <meta name="price" content="₹<?php echo $product['product_offer_price']; ?>">
    <meta name="availability" content="<?php echo $product['stock_status'] == '0' ? 'InStock' : 'OutOfStock'; ?>">
    <meta name="condition" content="New">
    <meta name="item-code" content="<?php echo $product['pid']; ?>">
    <meta name="brand" content="<?php echo sanitizeOutput($product['store_name']); ?>">
    <?php endif; ?>
    
    <!-- Additional Technical SEO Meta Tags -->
    <meta name="web_author" content="<?php echo SITE_NAME; ?>">
    <meta name="contact" content="support@thiyagi.com">
    <meta name="reply-to" content="support@thiyagi.com">
    <meta name="owner" content="<?php echo SITE_NAME; ?>">
    <meta name="url" content="<?php echo isset($canonicalUrl) ? $canonicalUrl : SITE_URL . $_SERVER['REQUEST_URI']; ?>">
    <meta name="identifier-URL" content="<?php echo isset($canonicalUrl) ? $canonicalUrl : SITE_URL . $_SERVER['REQUEST_URI']; ?>">
    <meta name="category" content="E-commerce, Shopping, Deals">
    <meta name="coverage" content="Worldwide">
    <meta name="directory" content="submission">
    <meta name="pagename" content="<?php echo isset($pageTitle) ? $pageTitle : SITE_NAME; ?>">
    <meta name="target" content="all">
    <meta name="audience" content="all">
    <meta name="expires" content="never">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta http-equiv="cleartype" content="on">
    <meta name="skype_toolbar" content="skype_toolbar_parser_compatible">
    
    <!-- Open Graph Meta Tags for Social Sharing -->
    <meta property="og:locale" content="en_IN">
    <meta property="og:type" content="<?php echo isset($product) ? 'product' : 'website'; ?>">
    <meta property="og:title" content="<?php echo isset($pageTitle) ? $pageTitle : SITE_NAME; ?>">
    <meta property="og:description" content="<?php echo isset($pageDescription) ? $pageDescription : 'Best deals and offers on various products in ' . date('Y'); ?>">
    <meta property="og:url" content="<?php echo isset($canonicalUrl) ? $canonicalUrl : SITE_URL . $_SERVER['REQUEST_URI']; ?>">
    <meta property="og:site_name" content="<?php echo SITE_NAME; ?>">
    <meta property="og:image" content="<?php echo isset($product) ? htmlspecialchars_decode($product['product_image']) : 'https://www.thiyagi.com/nt.png'; ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="<?php echo isset($product) ? sanitizeOutput($product['product_name']) : SITE_NAME . ' - Best Deals'; ?>">
    <meta property="og:updated_time" content="<?php echo date('c'); ?>">
    
    <!-- Facebook App ID (Optional - add your Facebook App ID) -->
    <!-- <meta property="fb:app_id" content="YOUR_FACEBOOK_APP_ID"> -->
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@thiyagicom">
    <meta name="twitter:creator" content="@thiyagicom">
    <meta name="twitter:title" content="<?php echo isset($pageTitle) ? $pageTitle : SITE_NAME; ?>">
    <meta name="twitter:description" content="<?php echo isset($pageDescription) ? $pageDescription : 'Best deals and offers on various products in ' . date('Y'); ?>">
    <meta name="twitter:image" content="<?php echo isset($product) ? htmlspecialchars_decode($product['product_image']) : 'https://www.thiyagi.com/nt.png'; ?>">
    <meta name="twitter:image:alt" content="<?php echo isset($product) ? sanitizeOutput($product['product_name']) : SITE_NAME . ' - Best Deals'; ?>">
    
    <!-- LinkedIn Meta Tags -->
    <meta property="og:image:secure_url" content="<?php echo isset($product) ? htmlspecialchars_decode($product['product_image']) : 'https://www.thiyagi.com/nt.png'; ?>">
    
    <!-- WhatsApp Meta Tags -->
    <meta property="og:image:type" content="image/jpeg">
    
    <!-- Article Schema for Social Media -->
    <meta property="article:author" content="<?php echo SITE_NAME; ?>">
    <meta property="article:publisher" content="<?php echo SITE_URL; ?>">
    <meta property="article:published_time" content="<?php echo isset($product) ? date('c', strtotime($product['date_time'])) : date('c'); ?>">
    <meta property="article:modified_time" content="<?php echo date('c'); ?>">
    <meta property="article:section" content="Shopping">
    <meta property="article:tag" content="deals, offers, shopping, <?php echo date('Y'); ?><?php echo isset($product) ? ', ' . sanitizeOutput($product['product_name']) . ', ' . sanitizeOutput($product['store_name']) : ''; ?>">
    
    <!-- Pinterest Meta Tags -->
    <meta name="pinterest-rich-pin" content="true">
    <?php if (isset($product)): ?>
    <meta property="og:price:amount" content="<?php echo $product['product_offer_price']; ?>">
    <meta property="og:price:currency" content="INR">
    <meta property="product:availability" content="<?php echo $product['stock_status'] == '0' ? 'in stock' : 'out of stock'; ?>">
    <meta property="product:condition" content="new">
    <meta property="product:price:amount" content="<?php echo $product['product_offer_price']; ?>">
    <meta property="product:price:currency" content="INR">
    <meta property="product:retailer_item_id" content="<?php echo $product['pid']; ?>">
    <?php endif; ?>
    
    <!-- Canonical URL -->
    <?php if (isset($canonicalUrl)): ?>
    <link rel="canonical" href="<?php echo $canonicalUrl; ?>">
    <?php else: ?>
    <link rel="canonical" href="<?php echo SITE_URL . $_SERVER['REQUEST_URI']; ?>">
    <?php endif; ?>
    
    <!-- Sitemap References -->
    <link rel="sitemap" type="application/xml" title="Sitemap" href="<?php echo SITE_URL; ?>/sitemap.xml">
    <link rel="sitemap" type="application/xml" title="Product Sitemap" href="<?php echo SITE_URL; ?>/sitemap-products.php">
    <link rel="sitemap" type="application/xml" title="Images Sitemap" href="<?php echo SITE_URL; ?>/sitemap-images-dynamic.php">
    
    <!-- Site Logo -->
    <?php $siteLogo = 'https://www.thiyagi.com/nt.png'; ?>
    
    <!-- Favicons and Icons -->
    <link rel="icon" type="image/png" href="<?php echo $siteLogo; ?>">
    <link rel="shortcut icon" type="image/png" href="<?php echo $siteLogo; ?>">
    <link rel="apple-touch-icon" href="<?php echo $siteLogo; ?>">
    <link rel="apple-touch-icon-precomposed" href="<?php echo $siteLogo; ?>">
    <meta name="msapplication-TileImage" content="<?php echo $siteLogo; ?>">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?php echo isset($pageTitle) ? $pageTitle : SITE_NAME; ?>">
    <meta property="og:description" content="<?php echo isset($pageDescription) ? $pageDescription : 'Best deals and offers on various products in ' . date('Y'); ?>">
    <meta property="og:type" content="<?php echo isset($product) ? 'product' : 'website'; ?>">
    <meta property="og:url" content="<?php echo isset($canonicalUrl) ? $canonicalUrl : SITE_URL . $_SERVER['REQUEST_URI']; ?>">
    <meta property="og:site_name" content="<?php echo SITE_NAME; ?>">
    <meta property="og:image" content="<?php echo isset($product) ? htmlspecialchars_decode($product['product_image']) : $siteLogo; ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:type" content="image/png">
    <?php if (isset($product)): ?>
    <meta property="product:price:amount" content="<?php echo $product['product_offer_price']; ?>">
    <meta property="product:price:currency" content="INR">
    <?php endif; ?>
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo isset($pageTitle) ? $pageTitle : SITE_NAME; ?>">
    <meta name="twitter:description" content="<?php echo isset($pageDescription) ? $pageDescription : 'Best deals and offers on various products in ' . date('Y'); ?>">
    <meta name="twitter:image" content="<?php echo isset($product) ? htmlspecialchars_decode($product['product_image']) : $siteLogo; ?>">
    <meta name="twitter:image:alt" content="<?php echo SITE_NAME; ?> Logo">
    
    <!-- Structured Data -->
    <?php if (isset($structuredData)): ?>
    <script type="application/ld+json">
    <?php echo json_encode($structuredData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?>
    </script>
    <?php endif; ?>
    
    <!-- FAQ Schema -->
    <?php if (isset($faqSchema)): ?>
    <script type="application/ld+json">
    <?php echo json_encode($faqSchema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?>
    </script>
    <?php endif; ?>
    
    <!-- Article Schema -->
    <?php if (isset($articleSchema)): ?>
    <script type="application/ld+json">
    <?php echo json_encode($articleSchema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?>
    </script>
    <?php endif; ?>
    
    <!-- HowTo Schema -->
    <?php if (isset($howToSchema)): ?>
    <script type="application/ld+json">
    <?php echo json_encode($howToSchema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?>
    </script>
    <?php endif; ?>
    
    <!-- Video Schema -->
    <?php if (isset($videoSchema)): ?>
    <script type="application/ld+json">
    <?php echo json_encode($videoSchema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?>
    </script>
    <?php endif; ?>
    
    <!-- Special Offer Schema -->
    <?php if (isset($specialOfferSchema)): ?>
    <script type="application/ld+json">
    <?php echo json_encode($specialOfferSchema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?>
    </script>
    <?php endif; ?>
    
    <!-- Collection Schema for Index Page -->
    <?php if (isset($collectionSchema)): ?>
    <script type="application/ld+json">
    <?php echo json_encode($collectionSchema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?>
    </script>
    <?php endif; ?>
    
    <!-- Local Business Schema -->
    <?php if (isset($localBusinessSchema)): ?>
    <script type="application/ld+json">
    <?php echo json_encode($localBusinessSchema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?>
    </script>
    <?php endif; ?>
    
    <!-- E-commerce Site Schema -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "<?php echo SITE_NAME; ?>",
        "alternateName": "Best Deals Shopping",
        "url": "<?php echo SITE_URL; ?>",
        "description": "India's leading deals and offers platform for electronics, fashion, home appliances and more",
        "inLanguage": "en-IN",
        "isAccessibleForFree": true,
        "isFamilyFriendly": true,
        "audience": {
            "@type": "Audience",
            "audienceType": "Consumer",
            "geographicArea": {
                "@type": "Country",
                "name": "India"
            }
        },
        "mainEntity": {
            "@type": "Organization",
            "name": "<?php echo SITE_NAME; ?>",
            "url": "<?php echo SITE_URL; ?>",
            "foundingDate": "2020",
            "areaServed": "India",
            "hasOfferCatalog": {
                "@type": "OfferCatalog",
                "name": "Product Deals",
                "itemListElement": [
                    {
                        "@type": "OfferCatalog",
                        "name": "Electronics Deals",
                        "itemListElement": {
                            "@type": "Offer",
                            "category": "Electronics"
                        }
                    },
                    {
                        "@type": "OfferCatalog", 
                        "name": "Fashion Deals",
                        "itemListElement": {
                            "@type": "Offer",
                            "category": "Fashion"
                        }
                    }
                ]
            }
        },
        "potentialAction": [
            {
                "@type": "SearchAction",
                "target": {
                    "@type": "EntryPoint",
                    "urlTemplate": "<?php echo SITE_URL; ?>/?search={search_term_string}"
                },
                "query-input": "required name=search_term_string"
            },
            {
                "@type": "ViewAction",
                "target": "<?php echo SITE_URL; ?>",
                "object": {
                    "@type": "WebPage",
                    "name": "Hot Deals"
                }
            }
        ]
    }
    </script>
    
    <!-- Merchant Return Policy Schema -->
    <?php if (isset($product)): ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "MerchantReturnPolicy",
        "applicableCountry": "IN",
        "returnPolicyCategory": "https://schema.org/MerchantReturnFiniteReturnWindow",
        "merchantReturnDays": 30,
        "returnMethod": "https://schema.org/ReturnByMail",
        "returnFees": "https://schema.org/FreeReturn",
        "name": "30-Day Return Policy",
        "description": "Items can be returned within 30 days of purchase in original condition"
    }
    </script>
    <?php endif; ?>
    
    <!-- Real Estate Business Schema -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "OnlineStore",
        "name": "<?php echo SITE_NAME; ?>",
        "url": "<?php echo SITE_URL; ?>",
        "logo": "<?php echo $siteLogo; ?>",
        "description": "Your trusted online destination for the best deals and offers",
        "currenciesAccepted": "INR",
        "paymentAccepted": [
            "Credit Card",
            "Debit Card", 
            "UPI",
            "Net Banking",
            "Digital Wallet"
        ],
        "priceRange": "₹100-₹100000",
        "address": {
            "@type": "PostalAddress",
            "addressCountry": "IN",
            "addressRegion": "Tamil Nadu",
            "addressLocality": "Chennai"
        },
        "hasOfferCatalog": {
            "@type": "OfferCatalog",
            "name": "Product Catalog",
            "itemListElement": {
                "@type": "Offer",
                "availability": "https://schema.org/InStock",
                "priceCurrency": "INR"
            }
        }
    }
    </script>
    
    <!-- Breadcrumb Structured Data -->
    <?php if (isset($product)): ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            {
                "@type": "ListItem",
                "position": 1,
                "name": "Home",
                "item": "<?php echo SITE_URL; ?>"
            },
            {
                "@type": "ListItem",
                "position": 2,
                "name": "Shop",
                "item": "<?php echo SITE_URL; ?>"
            },
            {
                "@type": "ListItem",
                "position": 3,
                "name": "<?php echo sanitizeOutput($product['product_name']); ?>",
                "item": "<?php echo $canonicalUrl; ?>"
            }
        ]
    }
    </script>
    
    <!-- Organization Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "<?php echo SITE_NAME; ?>",
        "url": "<?php echo SITE_URL; ?>",
        "logo": "<?php echo SITE_URL; ?>/assets/images/logo.png",
        "sameAs": [
            "https://thiyagi.com"
        ],
        "contactPoint": {
            "@type": "ContactPoint",
            "contactType": "Customer Service",
            "availableLanguage": ["English", "Tamil"]
        }
    }
    </script>
    
    <!-- Website Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "<?php echo SITE_NAME; ?>",
        "url": "<?php echo SITE_URL; ?>",
        "potentialAction": {
            "@type": "SearchAction",
            "target": "<?php echo SITE_URL; ?>/?search={search_term_string}",
            "query-input": "required name=search_term_string"
        }
    }
    </script>
    <?php endif; ?>
    
    <!-- PWA Manifest -->
    <link rel="manifest" href="<?php echo SITE_URL; ?>/manifest.json">
    
    <!-- Additional Meta Links -->
    <link rel="author" href="<?php echo SITE_URL; ?>/humans.txt">
    <link rel="security" href="<?php echo SITE_URL; ?>/security.txt">
    
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Custom Theme Styles -->
    <style>
        :root {
            --flipkart-blue: #2874f0;
            --amazon-orange: #ff9f00;
            --flipkart-dark: #1f5bc4;
            --success-green: #26a541;
            --danger-red: #e74c3c;
        }
        
        .btn-primary {
            background-color: var(--flipkart-blue);
            border-color: var(--flipkart-blue);
        }
        
        .btn-primary:hover {
            background-color: var(--flipkart-dark);
            border-color: var(--flipkart-dark);
        }
        
        .text-primary {
            color: var(--flipkart-blue) !important;
        }
        
        .bg-primary {
            background-color: var(--flipkart-blue) !important;
        }
        
        .navbar-brand:hover {
            color: var(--flipkart-dark) !important;
        }
        
        .nav-link:hover {
            color: var(--flipkart-blue) !important;
        }
        
        .badge.bg-success {
            background-color: var(--success-green) !important;
        }
        
        .badge.bg-danger {
            background-color: var(--danger-red) !important;
        }
        
        .form-control:focus {
            border-color: var(--flipkart-blue);
            box-shadow: 0 0 0 0.2rem rgba(40, 116, 240, 0.25);
        }
        
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        
        .dropdown-item:hover {
            background-color: #f8f9ff;
            color: var(--flipkart-blue);
        }
        
        .header {
            border-bottom: 1px solid #e0e6ed;
        }
        
        @media (max-width: 991.98px) {
            .navbar-nav .nav-item {
                border-bottom: 1px solid #eee;
                padding: 5px 0;
            }
            
            .navbar-nav .nav-item:last-child {
                border-bottom: none;
            }
        }
    </style>
    
    <!-- Preconnect to external domains -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://cdn.roo.bi">
    <link rel="preconnect" href="https://www.amazon.in">
</head>
<body>
    <header class="header bg-white shadow-sm">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <a class="navbar-brand fw-bold d-flex align-items-center" href="<?php echo SITE_URL; ?>" style="color: #2874f0;">
                    <img src="<?php echo $siteLogo; ?>" alt="<?php echo SITE_NAME; ?>" height="40" class="me-2">
                    <span class="fs-4"><?php echo SITE_NAME; ?></span>
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo SITE_URL; ?>">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://thiyagi.com" target="_blank">Main Site</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="main">