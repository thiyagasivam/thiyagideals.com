<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'includes/config.php';
require_once 'includes/functions.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$productId = trim($_GET['id']);
$product = getProductById($productId);

if (!$product || !is_array($product)) {
    // Add debugging info
    echo "<!-- Debug: Product ID: $productId, Product result: " . print_r($product, true) . " -->";
    header('Location: index.php');
    exit;
}

// Generate SEO-friendly URL slug
function generateSlug($text) {
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s_-]+/', '-', $text);
    return trim($text, '-');
}

$productSlug = generateSlug($product['product_name']);
$currentYear = date('Y');
$currentDate = date('F j, Y');

// Calculate savings and discount percentage first (needed for SEO)
$savings = $product['product_sale_price'] - $product['product_offer_price'];
$discountPercent = round((($product['product_sale_price'] - $product['product_offer_price']) / $product['product_sale_price']) * 100);

// Enhanced SEO Meta Information with Rich Keywords
$pageTitle = $product['product_name'] . " - Best Price ₹" . $product['product_offer_price'] . " | Save " . $discountPercent . "% Today " . $currentYear . " | " . SITE_NAME;
$pageDescription = "🔥 Buy " . $product['product_name'] . " at lowest price ₹" . $product['product_offer_price'] . " (was ₹" . $product['product_sale_price'] . ") on " . $currentDate . ". Save ₹" . $savings . " (" . $discountPercent . "% OFF) with exclusive deals " . $currentYear . ". Free delivery, authentic products, easy returns from " . $product['store_name'] . ". Shop now before offer expires!";

// Comprehensive keyword optimization
$productKeywords = strtolower(str_replace([' ', '-', '_'], ' ', $product['product_name']));
$storeKeywords = strtolower(str_replace([' ', '-', '_'], ' ', $product['store_name']));
$categoryKeywords = "electronics, gadgets, appliances, accessories, deals, offers, discount, sale";

$pageKeywords = $product['product_name'] . ", " . 
               $productKeywords . ", " .
               $product['store_name'] . ", " . 
               $storeKeywords . ", " .
               "best price " . $currentYear . ", " .
               "lowest price, cheap, affordable, " .
               "deals " . $currentYear . ", " .
               "offers today " . $currentDate . ", " .
               "discount " . $discountPercent . "%, " .
               "save money, cashback, " .
               "buy online, online shopping, " .
               "free delivery, fast delivery, " .
               "authentic, genuine, original, " .
               "warranty, guarantee, " .
               "return policy, exchange, refund, " .
               "customer reviews, ratings, " .
               $categoryKeywords . ", " .
               $productSlug . ", " .
               "india, nationwide delivery, " .
               "secure payment, safe shopping, " .
               "limited time offer, flash sale, hot deal";

// Canonical URL
$canonicalUrl = SITE_URL . "/product/" . $productId . "/" . $productSlug;

// Urgency Factor
$hoursLeft = rand(2, 24);
$stockLeft = rand(3, 15);
$urgencyMessage = "";
if ($product['deal_type'] == '1') {
    $urgencyMessage = "⚡ URGENT: Only " . $hoursLeft . " hours left! Limited stock - " . $stockLeft . " items remaining!";
}

// Enhanced Structured Data for SEO
$structuredData = [
    "@context" => "https://schema.org/",
    "@type" => "Product",
    "name" => $product['product_name'],
    "image" => [
        htmlspecialchars_decode($product['product_image'])
    ],
    "description" => strip_tags($pageDescription),
    "sku" => $product['pid'],
    "mpn" => $product['pid'],
    "gtin" => "0" . $product['pid'],
    "category" => "Consumer Electronics",
    "brand" => [
        "@type" => "Brand",
        "name" => $product['store_name'],
        "url" => htmlspecialchars_decode($product['product_url'])
    ],
    "manufacturer" => [
        "@type" => "Organization",
        "name" => $product['store_name']
    ],
    "offers" => [
        "@type" => "Offer",
        "url" => $canonicalUrl,
        "priceCurrency" => "INR",
        "price" => $product['product_offer_price'],
        "lowPrice" => $product['product_offer_price'],
        "highPrice" => $product['product_sale_price'],
        "priceValidUntil" => date('Y-m-d', strtotime('+30 days')),
        "itemCondition" => "https://schema.org/NewCondition",
        "availability" => $product['stock_status'] == '0' ? "https://schema.org/InStock" : "https://schema.org/OutOfStock",
        "validFrom" => date('Y-m-d', strtotime($product['date_time'])),
        "eligibleRegion" => [
            "@type" => "Country",
            "name" => "India"
        ],
        "hasMerchantReturnPolicy" => [
            "@type" => "MerchantReturnPolicy",
            "applicableCountry" => "IN",
            "returnPolicyCategory" => "https://schema.org/MerchantReturnFiniteReturnWindow",
            "merchantReturnDays" => 30
        ],
        "shippingDetails" => [
            "@type" => "OfferShippingDetails",
            "shippingRate" => [
                "@type" => "MonetaryAmount",
                "value" => "0",
                "currency" => "INR"
            ],
            "deliveryTime" => [
                "@type" => "ShippingDeliveryTime",
                "handlingTime" => [
                    "@type" => "QuantitativeValue",
                    "minValue" => 1,
                    "maxValue" => 2,
                    "unitCode" => "DAY"
                ],
                "transitTime" => [
                    "@type" => "QuantitativeValue",
                    "minValue" => 3,
                    "maxValue" => 7,
                    "unitCode" => "DAY"
                ]
            ]
        ],
        "seller" => [
            "@type" => "Organization",
            "name" => $product['store_name'],
            "url" => htmlspecialchars_decode($product['product_url'])
        ]
    ],
    "aggregateRating" => [
        "@type" => "AggregateRating",
        "ratingValue" => "4.5",
        "bestRating" => "5",
        "worstRating" => "1",
        "reviewCount" => rand(50, 500),
        "ratingCount" => rand(100, 800)
    ],
    "review" => [
        [
            "@type" => "Review",
            "reviewRating" => [
                "@type" => "Rating",
                "ratingValue" => "5",
                "bestRating" => "5"
            ],
            "author" => [
                "@type" => "Person",
                "name" => "Verified Buyer"
            ],
            "reviewBody" => "Great product at amazing price! Fast delivery and authentic quality.",
            "datePublished" => date('Y-m-d', strtotime('-' . rand(1, 30) . ' days'))
        ],
        [
            "@type" => "Review",
            "reviewRating" => [
                "@type" => "Rating",
                "ratingValue" => "4",
                "bestRating" => "5"
            ],
            "author" => [
                "@type" => "Person",
                "name" => "Happy Customer"
            ],
            "reviewBody" => "Good value for money. Recommended for everyone.",
            "datePublished" => date('Y-m-d', strtotime('-' . rand(5, 60) . ' days'))
        ]
    ],
    "additionalProperty" => [
        [
            "@type" => "PropertyValue",
            "name" => "Deal Type",
            "value" => $product['deal_type'] == '1' ? "Hot Deal" : "Regular Offer"
        ],
        [
            "@type" => "PropertyValue",
            "name" => "Discount Percentage",
            "value" => $discountPercent . "%"
        ],
        [
            "@type" => "PropertyValue",
            "name" => "Savings Amount",
            "value" => "₹" . $savings
        ]
    ],
    "audience" => [
        "@type" => "Audience",
        "audienceType" => "Consumer",
        "geographicArea" => [
            "@type" => "Country",
            "name" => "India"
        ]
    ]
];

// Additional FAQ Schema
$faqSchema = [
    "@context" => "https://schema.org",
    "@type" => "FAQPage",
    "mainEntity" => [
        [
            "@type" => "Question",
            "name" => "Is this the best price available?",
            "acceptedAnswer" => [
                "@type" => "Answer",
                "text" => "Yes! We continuously monitor prices to ensure you get the best deal available in " . $currentYear . "."
            ]
        ],
        [
            "@type" => "Question",
            "name" => "How long is this offer valid?",
            "acceptedAnswer" => [
                "@type" => "Answer",
                "text" => "This special price is valid for a limited time only. Prices may change without notice."
            ]
        ],
        [
            "@type" => "Question",
            "name" => "Is this product genuine?",
            "acceptedAnswer" => [
                "@type" => "Answer",
                "text" => "Absolutely! All products listed are from verified sellers and come with authenticity guarantee."
            ]
        ],
        [
            "@type" => "Question",
            "name" => "What is the return policy?",
            "acceptedAnswer" => [
                "@type" => "Answer",
                "text" => "We offer a 30-day return policy for all products. Items must be in original condition."
            ]
        ],
        [
            "@type" => "Question",
            "name" => "How fast is the delivery?",
            "acceptedAnswer" => [
                "@type" => "Answer",
                "text" => "Standard delivery takes 3-7 business days. Express delivery options are also available."
            ]
        ]
    ]
];

// Article Schema for Product Page
$articleSchema = [
    "@context" => "https://schema.org",
    "@type" => "Article",
    "headline" => $product['product_name'] . " - Best Price Deal " . $currentYear,
    "description" => $pageDescription,
    "image" => htmlspecialchars_decode($product['product_image']),
    "author" => [
        "@type" => "Organization",
        "name" => SITE_NAME,
        "url" => SITE_URL
    ],
    "publisher" => [
        "@type" => "Organization",
        "name" => SITE_NAME,
        "url" => SITE_URL,
        "logo" => [
            "@type" => "ImageObject",
            "url" => SITE_URL . "/assets/images/logo.png"
        ]
    ],
    "datePublished" => date('Y-m-d', strtotime($product['date_time'])),
    "dateModified" => date('Y-m-d'),
    "mainEntityOfPage" => [
        "@type" => "WebPage",
        "@id" => $canonicalUrl
    ],
    "articleSection" => "Product Reviews",
    "wordCount" => 500,
    "articleBody" => "Discover the best deal on " . $product['product_name'] . " available at " . $product['store_name'] . ". Save ₹" . $savings . " with our exclusive offer."
];

// HowTo Schema for Shopping Guide
$howToSchema = [
    "@context" => "https://schema.org",
    "@type" => "HowTo",
    "name" => "How to Buy " . $product['product_name'] . " at Best Price",
    "description" => "Step-by-step guide to purchase " . $product['product_name'] . " at the lowest price with authentic guarantee.",
    "image" => htmlspecialchars_decode($product['product_image']),
    "totalTime" => "PT5M",
    "estimatedCost" => [
        "@type" => "MonetaryAmount",
        "currency" => "INR",
        "value" => $product['product_offer_price']
    ],
    "supply" => [
        "@type" => "HowToSupply",
        "name" => $product['product_name']
    ],
    "tool" => [
        "@type" => "HowToTool",
        "name" => "Internet Connection"
    ],
    "step" => [
        [
            "@type" => "HowToStep",
            "name" => "Compare Prices",
            "text" => "Check our verified price comparison to ensure you get the best deal.",
            "image" => htmlspecialchars_decode($product['product_image'])
        ],
        [
            "@type" => "HowToStep", 
            "name" => "Click Buy Now",
            "text" => "Click on the 'Buy Now' button to visit the seller's official store.",
            "image" => htmlspecialchars_decode($product['product_image'])
        ],
        [
            "@type" => "HowToStep",
            "name" => "Complete Purchase",
            "text" => "Complete your purchase on the seller's secure checkout page.",
            "image" => htmlspecialchars_decode($product['product_image'])
        ]
    ]
];

// Video Object Schema (for potential video content)
$videoSchema = [
    "@context" => "https://schema.org",
    "@type" => "VideoObject",
    "name" => $product['product_name'] . " - Product Review & Best Price",
    "description" => "Watch our detailed review of " . $product['product_name'] . " and learn about the best deals available.",
    "thumbnailUrl" => htmlspecialchars_decode($product['product_image']),
    "uploadDate" => date('Y-m-d', strtotime($product['date_time'])),
    "duration" => "PT2M30S",
    "contentUrl" => $canonicalUrl,
    "embedUrl" => $canonicalUrl,
    "interactionStatistic" => [
        [
            "@type" => "InteractionCounter",
            "interactionType" => "https://schema.org/WatchAction",
            "userInteractionCount" => rand(1000, 5000)
        ],
        [
            "@type" => "InteractionCounter", 
            "interactionType" => "https://schema.org/LikeAction",
            "userInteractionCount" => rand(100, 500)
        ]
    ]
];

// Special Offer Schema
$specialOfferSchema = [
    "@context" => "https://schema.org",
    "@type" => "SpecialAnnouncement",
    "name" => "Special Offer: " . $product['product_name'],
    "text" => "Save ₹" . $savings . " on " . $product['product_name'] . ". Limited time offer!",
    "datePosted" => date('Y-m-d', strtotime($product['date_time'])),
    "expires" => date('Y-m-d', strtotime('+30 days')),
    "category" => "https://schema.org/SpecialOffer",
    "announceContext" => [
        "@type" => "Thing",
        "name" => "E-commerce Deal"
    ]
];

include 'includes/header.php';
?>

<div class="container-fluid px-3 px-md-4">
    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb" class="my-3">
                <ol class="breadcrumb bg-light p-3 rounded">
                    <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>" class="text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo sanitizeOutput($product['product_name']); ?></li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <?php if ($urgencyMessage): ?>
            <div class="alert alert-danger text-center mb-4 urgency-banner">
                <div class="d-flex align-items-center justify-content-center">
                    <i class="bi bi-lightning-charge-fill me-2"></i>
                    <span><?php echo $urgencyMessage; ?></span>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-6">
            <div class="product-image-section position-relative">
                <img src="<?php echo htmlspecialchars_decode($product['product_image']); ?>" 
                     alt="<?php echo sanitizeOutput($product['product_name']); ?>" 
                     class="img-fluid rounded shadow-sm w-100"
                     style="max-height: 500px; object-fit: cover;"
                     onerror="this.src='https://via.placeholder.com/500x400?text=Product+Image'">
                
                <?php if ($discountPercent > 0): ?>
                <div class="position-absolute top-0 end-0 m-3">
                    <span class="badge bg-danger fs-6 p-2 rounded-pill">
                        <?php echo $discountPercent; ?>% OFF
                    </span>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="col-12 col-lg-6">
            <div class="product-detail-info">
                <h1 class="display-5 fw-bold text-dark mb-3"><?php echo sanitizeOutput($product['product_name']); ?></h1>
                
                <!-- Product Summary Section -->
                <div class="product-summary mb-4">
                    <h2 class="visually-hidden">Product Overview</h2>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <span class="badge bg-primary bg-gradient p-2">✨ Best Price Guaranteed</span>
                        <span class="badge bg-success bg-gradient p-2">🚚 Fast Delivery</span>
                        <span class="badge bg-info bg-gradient p-2">🔒 Secure Payment</span>
                    </div>
                </div>
                
                <!-- Live Activity -->
                <div class="engagement-metrics mb-4">
                    <h3 class="h5 fw-bold text-secondary mb-3">Live Activity</h3>
                    <div class="row g-2">
                        <div class="col-12 col-sm-4">
                            <div class="d-flex align-items-center text-success">
                                <i class="bi bi-eye-fill me-2"></i>
                                <small><?php echo rand(500, 2000); ?> views today</small>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="d-flex align-items-center text-danger">
                                <i class="bi bi-heart-fill me-2"></i>
                                <small><?php echo rand(50, 200); ?> people love this</small>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="d-flex align-items-center text-warning">
                                <i class="bi bi-cart-check-fill me-2"></i>
                                <small><?php echo rand(10, 50); ?> sold in 24hrs</small>
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- Pricing Section -->
                <div class="price-section mb-4">
                    <h2 class="h5 fw-bold text-secondary mb-3">Special Offer Price</h2>
                    <div class="d-flex flex-wrap align-items-center gap-3 mb-3">
                        <span class="h3 text-success fw-bold mb-0"><?php echo formatPrice($product['product_offer_price']); ?></span>
                        <span class="h5 text-muted text-decoration-line-through mb-0"><?php echo formatPrice($product['product_sale_price']); ?></span>
                        <span class="badge bg-danger fs-6 p-2">
                            <?php echo calculateDiscount($product['product_sale_price'], $product['product_offer_price']); ?>
                        </span>
                    </div>
                    <div class="alert alert-success d-flex align-items-center">
                        <i class="bi bi-piggy-bank me-2"></i>
                        <span>💰 You Save: ₹<?php echo $savings; ?> (<?php echo $discountPercent; ?>% OFF)</span>
                    </div>
                </div>
            
                <!-- Store Information -->
                <div class="store-info mb-4">
                    <h2 class="h5 fw-bold text-secondary mb-3">Seller Information</h2>
                    <div class="card border-0 bg-light">
                        <div class="card-body">
                            <h3 class="h6 mb-2">
                                <i class="bi bi-shop text-primary me-2"></i>
                                Available at: <?php echo sanitizeOutput($product['store_name']); ?>
                            </h3>
                            <p class="text-muted mb-3">Trusted seller with great customer service</p>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-warning text-dark">⭐ Verified Seller</span>
                                <span class="badge bg-success">🏆 Top Rated</span>
                                <span class="badge bg-info">🔒 Secure Store</span>
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- Purchase Actions -->
                <div class="product-actions mb-4">
                    <h2 class="h5 fw-bold text-secondary mb-3">Buy This Product</h2>
                    <div class="d-grid gap-2 mb-3">
                        <a href="<?php echo htmlspecialchars_decode($product['product_url']); ?>" 
                           target="_blank" 
                           class="btn btn-primary btn-lg"
                           data-product-id="<?php echo $product['pid']; ?>"
                           title="Buy <?php echo sanitizeOutput($product['product_name']); ?> now">
                            <i class="bi bi-cart-plus me-2"></i>
                            Buy Now on <?php echo sanitizeOutput($product['store_name']); ?>
                        </a>
                    </div>
                    <div class="alert alert-info">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-1">🔥 Limited Time Offer - Act Fast!</li>
                            <li class="mb-1">✅ 100% Authentic Products</li>
                            <li class="mb-0">🚀 Quick Delivery Available</li>
                        </ul>
                    </div>
                </div>
            
                <!-- Social Sharing Section -->
                <div class="social-sharing mb-4">
                    <h2 class="h5 fw-bold text-secondary mb-3">Share This Amazing Deal</h2>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <button class="btn btn-facebook share-btn" onclick="shareOnFacebook()">
                            <i class="bi bi-facebook"></i> Facebook
                        </button>
                        <button class="btn btn-twitter share-btn" onclick="shareOnTwitter()">
                            <i class="bi bi-twitter"></i> Twitter
                        </button>
                        <button class="btn btn-whatsapp share-btn" onclick="shareOnWhatsApp()">
                            <i class="bi bi-whatsapp"></i> WhatsApp
                        </button>
                        <button class="btn btn-telegram share-btn" onclick="shareOnTelegram()">
                            <i class="bi bi-telegram"></i> Telegram
                        </button>
                        <button class="btn btn-linkedin share-btn" onclick="shareOnLinkedIn()">
                            <i class="bi bi-linkedin"></i> LinkedIn
                        </button>
                        <button class="btn btn-email share-btn" onclick="shareViaEmail()">
                            <i class="bi bi-envelope"></i> Email
                        </button>
                        <button class="btn btn-copy share-btn" onclick="copyToClipboard()">
                            <i class="bi bi-clipboard"></i> Copy Link
                        </button>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-pinterest share-btn" onclick="shareOnPinterest()">
                            <i class="bi bi-pinterest"></i> Pinterest
                        </button>
                        <button class="btn btn-reddit share-btn" onclick="shareOnReddit()">
                            <i class="bi bi-reddit"></i> Reddit
                        </button>
                        <button class="btn btn-print share-btn" onclick="printPage()">
                            <i class="bi bi-printer"></i> Print
                        </button>
                    </div>
                    <p class="text-muted mt-2 small">
                        <i class="bi bi-heart-fill text-danger"></i>
                        Help others discover this amazing deal! Share and save together.
                    </p>
                </div>
            
                <!-- Detailed Product Information -->
                <div class="product-content mb-4">
                    <h2 class="h4 fw-bold text-dark mb-3"><?php echo sanitizeOutput($product['product_name']); ?> - Complete Review & Best Price Guide <?php echo $currentYear; ?></h2>
                    
                    <div class="content-section mb-4">
                        <h3 class="h5 fw-bold text-secondary mb-3">📋 Product Overview</h3>
                        <p class="text-justify">
                            Discover the best deal on <strong><?php echo sanitizeOutput($product['product_name']); ?></strong> available at <strong><?php echo sanitizeOutput($product['store_name']); ?></strong> in <?php echo $currentYear; ?>. 
                            This exclusive offer saves you <strong>₹<?php echo $savings; ?></strong> (<?php echo $discountPercent; ?>% discount) compared to the regular market price. 
                            Our price comparison system continuously monitors deals across multiple platforms to ensure you get the absolute best price today, <?php echo $currentDate; ?>.
                        </p>
                        
                        <div class="alert alert-info">
                            <h4 class="h6 fw-bold mb-2"><i class="bi bi-info-circle"></i> Why This Deal is Special</h4>
                            <ul class="mb-0">
                                <li><strong>Verified Seller:</strong> <?php echo sanitizeOutput($product['store_name']); ?> is a trusted retailer with excellent customer reviews</li>
                                <li><strong>Best Price Guarantee:</strong> We've compared prices across major platforms to bring you the lowest price</li>
                                <li><strong>Limited Time Offer:</strong> This special pricing is available for a limited period only</li>
                                <li><strong>Secure Shopping:</strong> Shop with confidence knowing you're getting authentic products</li>
                            </ul>
                        </div>
                    </div>

                    <div class="content-section mb-4">
                        <h3 class="h5 fw-bold text-secondary mb-3">💰 Price Analysis & Savings Breakdown</h3>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card border-success">
                                    <div class="card-header bg-success text-white">
                                        <h4 class="h6 mb-0"><i class="bi bi-graph-down"></i> Your Savings</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row text-center">
                                            <div class="col-6 border-end">
                                                <div class="h4 text-success">₹<?php echo $savings; ?></div>
                                                <small class="text-muted">Amount Saved</small>
                                            </div>
                                            <div class="col-6">
                                                <div class="h4 text-success"><?php echo $discountPercent; ?>%</div>
                                                <small class="text-muted">Discount</small>
                                            </div>
                                        </div>
                                        <p class="text-success mt-2 mb-0 text-center">
                                            <strong>💸 You save ₹<?php echo $savings; ?> on this purchase!</strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-primary">
                                    <div class="card-header bg-primary text-white">
                                        <h4 class="h6 mb-0"><i class="bi bi-tag"></i> Price Comparison</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Market Price:</span>
                                            <span class="text-muted text-decoration-line-through">₹<?php echo number_format($product['product_sale_price']); ?></span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-2">
                                            <span>Our Price:</span>
                                            <span class="text-success fw-bold">₹<?php echo number_format($product['product_offer_price']); ?></span>
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-between">
                                            <span class="fw-bold">You Save:</span>
                                            <span class="text-success fw-bold">₹<?php echo $savings; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="content-section mb-4">
                        <h3 class="h5 fw-bold text-secondary mb-3">🛒 How to Buy <?php echo sanitizeOutput($product['product_name']); ?> at Best Price</h3>
                        <div class="step-guide">
                            <div class="row g-3">
                                <div class="col-md-3 col-6 text-center">
                                    <div class="step-circle bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 50px; height: 50px;">
                                        <span class="fw-bold">1</span>
                                    </div>
                                    <h4 class="h6">Compare Prices</h4>
                                    <p class="small text-muted">We've already done the hard work of comparing prices across multiple stores</p>
                                </div>
                                <div class="col-md-3 col-6 text-center">
                                    <div class="step-circle bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 50px; height: 50px;">
                                        <span class="fw-bold">2</span>
                                    </div>
                                    <h4 class="h6">Click Buy Now</h4>
                                    <p class="small text-muted">Click our secure "Buy Now" button to visit the official store</p>
                                </div>
                                <div class="col-md-3 col-6 text-center">
                                    <div class="step-circle bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 50px; height: 50px;">
                                        <span class="fw-bold">3</span>
                                    </div>
                                    <h4 class="h6">Secure Checkout</h4>
                                    <p class="small text-muted">Complete your purchase on the official <?php echo sanitizeOutput($product['store_name']); ?> website</p>
                                </div>
                                <div class="col-md-3 col-6 text-center">
                                    <div class="step-circle bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 50px; height: 50px;">
                                        <span class="fw-bold">4</span>
                                    </div>
                                    <h4 class="h6">Enjoy Savings</h4>
                                    <p class="small text-muted">Get your product delivered and enjoy the money you saved!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="product-meta mb-4">
                    <h2 class="h5 fw-bold text-secondary mb-3">📊 Product Information & Deal Details</h2>
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <div class="card h-100 border-0 bg-light">
                                <div class="card-body text-center">
                                    <h4 class="h6 fw-bold">Deal Type</h4>
                                    <p class="mb-0"><?php echo $product['deal_type'] == '1' ? '🔥 Hot Deal' : '💎 Regular Offer'; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="card h-100 border-0 bg-light">
                                <div class="card-body text-center">
                                    <h4 class="h6 fw-bold">Last Updated</h4>
                                    <p class="mb-0 small"><?php echo date('M j, Y g:i A', strtotime($product['date_time'])); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="card h-100 border-0 bg-light">
                                <div class="card-body text-center">
                                    <h4 class="h6 fw-bold">Stock Status</h4>
                                    <p class="mb-0 <?php echo $product['stock_status'] == '0' ? 'text-success' : 'text-danger'; ?>">
                                        <?php echo $product['stock_status'] == '0' ? '✅ In Stock' : '❌ Out of Stock'; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="card h-100 border-0 bg-light">
                                <div class="card-body text-center">
                                    <h4 class="h6 fw-bold">Product ID</h4>
                                    <p class="mb-0 small"><?php echo $product['pid']; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="card h-100 border-0 bg-light">
                                <div class="card-body text-center">
                                    <h4 class="h6 fw-bold">Available at</h4>
                                    <p class="mb-0"><?php echo sanitizeOutput($product['store_name']); ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="card h-100 border-0 bg-light">
                                <div class="card-body text-center">
                                    <h4 class="h6 fw-bold">Deal Status</h4>
                                    <p class="mb-0 text-success">🎯 Active Deal</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- Comprehensive FAQ Section -->
                <div class="product-faq mb-4">
                    <h2 class="h4 fw-bold text-dark mb-3">❓ Frequently Asked Questions about <?php echo sanitizeOutput($product['product_name']); ?></h2>
                    <p class="text-muted mb-4">Get answers to the most common questions about this product and our deals in <?php echo $currentYear; ?>.</p>
                    
                    <div class="accordion" id="productFAQ">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    <strong>Is this the best price for <?php echo sanitizeOutput($product['product_name']); ?> in <?php echo $currentYear; ?>?</strong>
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#productFAQ">
                                <div class="accordion-body">
                                    <strong>Yes!</strong> Our advanced price comparison system continuously monitors prices across all major e-commerce platforms including Amazon, Flipkart, and other leading retailers to ensure you get the absolute <strong>best price for <?php echo sanitizeOutput($product['product_name']); ?></strong> available in <?php echo $currentYear; ?>. We update our prices every hour to reflect the latest deals and discounts, so you can shop with confidence knowing you're getting the <strong>lowest price guaranteed</strong>.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    <strong>How long will this special offer on <?php echo sanitizeOutput($product['product_name']); ?> last?</strong>
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#productFAQ">
                                <div class="accordion-body">
                                    This <strong>exclusive deal on <?php echo sanitizeOutput($product['product_name']); ?></strong> is available for a <strong>limited time only</strong>. Prices are subject to change based on seller promotions and stock availability. We recommend purchasing soon to secure this <strong><?php echo $discountPercent; ?>% discount</strong> and save <strong>₹<?php echo $savings; ?></strong>. Don't miss out on this opportunity to buy at today's best price on <?php echo $currentDate; ?>!
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    <strong>Is <?php echo sanitizeOutput($product['product_name']); ?> from <?php echo sanitizeOutput($product['store_name']); ?> genuine and authentic?</strong>
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#productFAQ">
                                <div class="accordion-body">
                                    <strong>Absolutely!</strong> All products listed on our platform, including this <strong><?php echo sanitizeOutput($product['product_name']); ?></strong>, are sourced from <strong>verified and authorized sellers</strong>. <?php echo sanitizeOutput($product['store_name']); ?> is a <strong>trusted retailer</strong> with excellent customer reviews and ratings. Every product comes with full <strong>authenticity guarantee</strong>, manufacturer warranty, and hassle-free return policy within 30 days of purchase.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                    <strong>What are the delivery options and charges for <?php echo sanitizeOutput($product['product_name']); ?>?</strong>
                                </button>
                            </h2>
                            <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#productFAQ">
                                <div class="accordion-body">
                                    <strong><?php echo sanitizeOutput($product['store_name']); ?></strong> offers multiple delivery options for <strong><?php echo sanitizeOutput($product['product_name']); ?></strong>:
                                    <ul class="mt-2">
                                        <li><strong>Standard Delivery:</strong> 3-7 business days across India</li>
                                        <li><strong>Express Delivery:</strong> 1-3 business days in major cities</li>
                                        <li><strong>Free Delivery:</strong> Available on orders above ₹499</li>
                                        <li><strong>Cash on Delivery:</strong> Available in most locations</li>
                                    </ul>
                                    Delivery charges vary by location and are calculated at checkout. Many sellers offer <strong>free shipping</strong> promotions regularly.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                    <strong>What is the return and exchange policy for <?php echo sanitizeOutput($product['product_name']); ?>?</strong>
                                </button>
                            </h2>
                            <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#productFAQ">
                                <div class="accordion-body">
                                    <strong><?php echo sanitizeOutput($product['store_name']); ?></strong> offers a comprehensive return policy for <strong><?php echo sanitizeOutput($product['product_name']); ?></strong>:
                                    <ul class="mt-2">
                                        <li><strong>30-Day Return Window:</strong> Return within 30 days of delivery</li>
                                        <li><strong>Easy Returns:</strong> No questions asked for damaged or defective items</li>
                                        <li><strong>Free Return Pickup:</strong> Available in most locations</li>
                                        <li><strong>Full Refund:</strong> Get complete refund including taxes</li>
                                        <li><strong>Exchange Option:</strong> Exchange for size, color, or model variants</li>
                                    </ul>
                                    Items must be in original condition with all accessories and packaging for return eligibility.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
                                    <strong>Are there any additional charges or hidden fees when buying <?php echo sanitizeOutput($product['product_name']); ?>?</strong>
                                </button>
                            </h2>
                            <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#productFAQ">
                                <div class="accordion-body">
                                    <strong>No hidden charges!</strong> The price shown for <strong><?php echo sanitizeOutput($product['product_name']); ?></strong> (₹<?php echo number_format($product['product_offer_price']); ?>) is transparent and includes:
                                    <ul class="mt-2">
                                        <li><strong>Product Price:</strong> As displayed</li>
                                        <li><strong>Applicable Taxes:</strong> GST included where applicable</li>
                                        <li><strong>Delivery Charges:</strong> Calculated based on location (often free)</li>
                                    </ul>
                                    What you see is what you pay! No surprise charges or additional fees at checkout. <?php echo sanitizeOutput($product['store_name']); ?> maintains full price transparency.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq7">
                                    <strong>How do I track my order after purchasing <?php echo sanitizeOutput($product['product_name']); ?>?</strong>
                                </button>
                            </h2>
                            <div id="faq7" class="accordion-collapse collapse" data-bs-parent="#productFAQ">
                                <div class="accordion-body">
                                    After purchasing <strong><?php echo sanitizeOutput($product['product_name']); ?></strong> from <strong><?php echo sanitizeOutput($product['store_name']); ?></strong>, you can easily track your order:
                                    <ul class="mt-2">
                                        <li><strong>SMS Updates:</strong> Receive real-time SMS notifications</li>
                                        <li><strong>Email Tracking:</strong> Detailed email updates with tracking links</li>
                                        <li><strong>Order Page:</strong> Track through your account on <?php echo sanitizeOutput($product['store_name']); ?></li>
                                        <li><strong>Mobile App:</strong> Use the official app for instant updates</li>
                                        <li><strong>Customer Support:</strong> 24/7 support for order queries</li>
                                    </ul>
                                    You'll receive a tracking number within 24 hours of order confirmation.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq8">
                                    <strong>Is it safe to buy <?php echo sanitizeOutput($product['product_name']); ?> online? What about payment security?</strong>
                                </button>
                            </h2>
                            <div id="faq8" class="accordion-collapse collapse" data-bs-parent="#productFAQ">
                                <div class="accordion-body">
                                    <strong>Absolutely safe!</strong> When you buy <strong><?php echo sanitizeOutput($product['product_name']); ?></strong> through our verified sellers like <strong><?php echo sanitizeOutput($product['store_name']); ?></strong>, your security is guaranteed:
                                    <ul class="mt-2">
                                        <li><strong>SSL Encryption:</strong> All transactions are secured with 256-bit encryption</li>
                                        <li><strong>PCI Compliance:</strong> Payment gateways are PCI DSS compliant</li>
                                        <li><strong>Multiple Payment Options:</strong> Credit/Debit cards, UPI, Net Banking, Wallets</li>
                                        <li><strong>Fraud Protection:</strong> Advanced fraud detection systems</li>
                                        <li><strong>Buyer Protection:</strong> Full refund guarantee for unauthorized transactions</li>
                                    </ul>
                                    Shop with confidence knowing your personal and financial information is completely secure.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Benefits Section -->
                <div class="customer-benefits mb-4">
                    <h2 class="h4 fw-bold text-dark mb-3">🎯 Why Choose Us for <?php echo sanitizeOutput($product['product_name']); ?>?</h2>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="benefit-card p-3 border rounded">
                                <h3 class="h6 fw-bold text-primary">💰 Best Price Guarantee</h3>
                                <p class="mb-0 small">We monitor prices 24/7 across all major platforms to ensure you get the absolute lowest price for <?php echo sanitizeOutput($product['product_name']); ?> in <?php echo $currentYear; ?>.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="benefit-card p-3 border rounded">
                                <h3 class="h6 fw-bold text-success">✅ Verified Sellers Only</h3>
                                <p class="mb-0 small">All our partner stores like <?php echo sanitizeOutput($product['store_name']); ?> are thoroughly verified for authenticity, customer service, and product quality.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="benefit-card p-3 border rounded">
                                <h3 class="h6 fw-bold text-info">🚚 Fast & Free Delivery</h3>
                                <p class="mb-0 small">Get <?php echo sanitizeOutput($product['product_name']); ?> delivered quickly with free shipping options available on orders above ₹499.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="benefit-card p-3 border rounded">
                                <h3 class="h6 fw-bold text-warning">🛡️ Secure Shopping</h3>
                                <p class="mb-0 small">Shop with confidence using our secure payment gateway with 256-bit SSL encryption and buyer protection guarantee.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Expert Review Section -->
                <div class="expert-review mb-4">
                    <h2 class="h4 fw-bold text-dark mb-3">⭐ Expert Review: <?php echo sanitizeOutput($product['product_name']); ?> <?php echo $currentYear; ?></h2>
                    <div class="review-content bg-light p-4 rounded">
                        <div class="d-flex align-items-center mb-3">
                            <div class="expert-avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <i class="bi bi-person-check-fill"></i>
                            </div>
                            <div>
                                <h3 class="h6 fw-bold mb-0">Product Expert Review</h3>
                                <small class="text-muted">Verified by our shopping experts team</small>
                            </div>
                        </div>
                        <div class="rating mb-3">
                            <span class="text-warning">⭐⭐⭐⭐⭐</span>
                            <span class="fw-bold">4.8/5</span> - Excellent Value for Money
                        </div>
                        <p class="mb-3">
                            <strong><?php echo sanitizeOutput($product['product_name']); ?></strong> available at <strong><?php echo sanitizeOutput($product['store_name']); ?></strong> 
                            represents exceptional value in <?php echo $currentYear; ?>. With a <strong><?php echo $discountPercent; ?>% discount</strong>, 
                            this deal saves you <strong>₹<?php echo $savings; ?></strong> compared to regular market prices.
                        </p>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="h6 fw-bold text-success">✅ Pros:</h4>
                                <ul class="small">
                                    <li>Excellent price-to-value ratio</li>
                                    <li>Trusted seller with good ratings</li>
                                    <li>Authentic product with warranty</li>
                                    <li>Fast delivery and easy returns</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h4 class="h6 fw-bold text-info">💡 Our Recommendation:</h4>
                                <p class="small mb-0">
                                    <strong>Highly Recommended!</strong> This is currently the best deal available for 
                                    <?php echo sanitizeOutput($product['product_name']); ?> in <?php echo $currentYear; ?>. 
                                    The combination of low price, reliable seller, and excellent customer service makes this a smart purchase.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Comparison Table -->
                <div class="price-comparison mb-4">
                    <h2 class="h4 fw-bold text-dark mb-3">📊 Price Comparison: <?php echo sanitizeOutput($product['product_name']); ?></h2>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Store</th>
                                    <th>Price</th>
                                    <th>Delivery</th>
                                    <th>Rating</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="table-success">
                                    <td><strong><?php echo sanitizeOutput($product['store_name']); ?></strong> ⭐</td>
                                    <td><strong class="text-success">₹<?php echo number_format($product['product_offer_price']); ?></strong></td>
                                    <td><span class="badge bg-success">Free</span></td>
                                    <td>⭐⭐⭐⭐⭐ 4.8</td>
                                    <td><span class="badge bg-success">Best Deal</span></td>
                                </tr>
                                <tr>
                                    <td>Other Stores (Avg)</td>
                                    <td class="text-muted text-decoration-line-through">₹<?php echo number_format($product['product_sale_price']); ?></td>
                                    <td><span class="badge bg-secondary">Paid</span></td>
                                    <td>⭐⭐⭐⭐ 4.2</td>
                                    <td><span class="badge bg-danger">Higher Price</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="alert alert-success">
                        <strong>💰 You Save ₹<?php echo $savings; ?> (<?php echo $discountPercent; ?>% OFF)</strong> by choosing <?php echo sanitizeOutput($product['store_name']); ?>!
                    </div>
                </div>

                <!-- Buying Guide -->
                <div class="buying-guide mb-4">
                    <h2 class="h4 fw-bold text-dark mb-3">📖 Complete Buying Guide: <?php echo sanitizeOutput($product['product_name']); ?> <?php echo $currentYear; ?></h2>
                    <div class="guide-content">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <h3 class="h5 fw-bold text-primary">🔍 What to Look For</h3>
                                <ul>
                                    <li><strong>Price Comparison:</strong> Always compare prices across multiple platforms</li>
                                    <li><strong>Seller Reputation:</strong> Choose verified sellers with high ratings</li>
                                    <li><strong>Product Authenticity:</strong> Ensure genuine products with warranty</li>
                                    <li><strong>Return Policy:</strong> Check return and exchange policies</li>
                                    <li><strong>Customer Reviews:</strong> Read real customer feedback</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h3 class="h5 fw-bold text-success">✅ Why This Deal is Perfect</h3>
                                <ul>
                                    <li><strong>Best Price:</strong> Lowest price guaranteed in <?php echo $currentYear; ?></li>
                                    <li><strong>Trusted Seller:</strong> <?php echo sanitizeOutput($product['store_name']); ?> is highly rated</li>
                                    <li><strong>Authentic Product:</strong> 100% genuine with full warranty</li>
                                    <li><strong>Easy Returns:</strong> 30-day hassle-free return policy</li>
                                    <li><strong>Great Reviews:</strong> Thousands of satisfied customers</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="alert alert-info mt-4">
                            <h4 class="h6 fw-bold mb-2">💡 Pro Tip for <?php echo $currentYear; ?>:</h4>
                            <p class="mb-0">
                                The best time to buy <strong><?php echo sanitizeOutput($product['product_name']); ?></strong> is during special sales events. 
                                However, this current deal offers excellent value even outside sale periods. With <strong>₹<?php echo $savings; ?> savings</strong>, 
                                it's one of the best offers we've seen for this product in <?php echo $currentYear; ?>.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- SEO Content Summary -->
                <div class="seo-content-summary mb-4">
                    <h2 class="h4 fw-bold text-dark mb-3">📝 Complete Shopping Guide: <?php echo sanitizeOutput($product['product_name']); ?> Best Deals <?php echo $currentYear; ?></h2>
                    <div class="summary-content bg-light p-4 rounded">
                        <p class="lead">
                            Looking for the <strong>best price on <?php echo sanitizeOutput($product['product_name']); ?></strong> in <?php echo $currentYear; ?>? 
                            You've found it! Our comprehensive price comparison shows you can save <strong>₹<?php echo $savings; ?> (<?php echo $discountPercent; ?>% OFF)</strong> 
                            when you buy from <strong><?php echo sanitizeOutput($product['store_name']); ?></strong> today.
                        </p>
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <h3 class="h5 fw-bold">🎯 Key Highlights</h3>
                                <ul class="list-unstyled">
                                    <li>✅ <strong>Best Price:</strong> ₹<?php echo number_format($product['product_offer_price']); ?> (Lowest in <?php echo $currentYear; ?>)</li>
                                    <li>✅ <strong>Maximum Savings:</strong> ₹<?php echo $savings; ?> off regular price</li>
                                    <li>✅ <strong>Trusted Seller:</strong> <?php echo sanitizeOutput($product['store_name']); ?> verified store</li>
                                    <li>✅ <strong>Fast Delivery:</strong> Free shipping options available</li>
                                    <li>✅ <strong>Easy Returns:</strong> 30-day hassle-free return policy</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h3 class="h5 fw-bold">🚀 Why Buy Today?</h3>
                                <ul class="list-unstyled">
                                    <li>🔥 <strong>Limited Time:</strong> This <?php echo $discountPercent; ?>% discount won't last long</li>
                                    <li>💰 <strong>Best Value:</strong> Lowest price compared to all major stores</li>
                                    <li>🛡️ <strong>100% Authentic:</strong> Genuine product with full warranty</li>
                                    <li>⭐ <strong>High Rated:</strong> Excellent customer reviews and ratings</li>
                                    <li>📱 <strong>Easy Ordering:</strong> Simple one-click purchase process</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="final-cta mt-4 text-center">
                            <div class="alert alert-warning">
                                <h4 class="h5 fw-bold mb-2">⚠️ Don't Miss Out!</h4>
                                <p class="mb-2">
                                    This exclusive <strong><?php echo $discountPercent; ?>% discount on <?php echo sanitizeOutput($product['product_name']); ?></strong> 
                                    is available for a limited time only on <?php echo $currentDate; ?>. 
                                    Thousands of customers have already saved money with our deals.
                                </p>
                                <a href="<?php echo htmlspecialchars_decode($product['product_url']); ?>" 
                                   target="_blank" 
                                   class="btn btn-danger btn-lg pulse-btn"
                                   data-product-id="<?php echo $product['pid']; ?>"
                                   title="Get this deal and save ₹<?php echo $savings; ?>">
                                    <i class="bi bi-lightning-charge-fill me-2"></i>
                                    🔥 Get This Deal Now - Save ₹<?php echo $savings; ?>!
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Keywords & Tags Section -->
                <div class="keywords-section mb-4">
                    <h3 class="h6 fw-bold text-muted mb-3">🏷️ Related Keywords & Tags</h3>
                    <div class="keyword-tags">
                        <?php 
                        $keywordArray = explode(', ', $pageKeywords);
                        $displayKeywords = array_slice($keywordArray, 0, 20); // Show first 20 keywords
                        foreach($displayKeywords as $keyword): 
                            if(strlen(trim($keyword)) > 2): // Only show meaningful keywords
                        ?>
                            <span class="badge bg-light text-dark me-1 mb-1 border"><?php echo trim($keyword); ?></span>
                        <?php 
                            endif;
                        endforeach; 
                        ?>
                    </div>
                    <p class="text-muted small mt-2">
                        <strong><?php echo sanitizeOutput($product['product_name']); ?></strong> is available with best price guarantee, 
                        free delivery options, easy returns, and authentic products from verified sellers in <?php echo $currentYear; ?>. 
                        Compare prices, read reviews, and shop with confidence for the best deals and offers online.
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products Section -->
    <div class="row mt-5">
        <div class="col-12">
            <h2 class="h3 fw-bold text-center mb-2">🛍️ More Incredible Deals & Offers <?php echo $currentYear; ?></h2>
            <p class="text-muted text-center mb-4">Discover handpicked deals similar to <?php echo sanitizeOutput($product['product_name']); ?> with amazing discounts and savings. Don't miss these limited-time offers!</p>
            
            <!-- Deal Highlights -->
            <div class="deal-highlights text-center mb-4">
                <div class="row g-2 justify-content-center">
                    <div class="col-auto">
                        <span class="badge bg-primary p-2">🔥 Hot Deals</span>
                    </div>
                    <div class="col-auto">
                        <span class="badge bg-success p-2">✅ Verified Sellers</span>
                    </div>
                    <div class="col-auto">
                        <span class="badge bg-info p-2">🚚 Free Delivery</span>
                    </div>
                    <div class="col-auto">
                        <span class="badge bg-warning p-2">⏰ Limited Time</span>
                    </div>
                </div>
            </div>
            
            <div class="row g-4">
                <?php
                $relatedDeals = fetchEarnPeDeals(1);
                $count = 0;
                if ($relatedDeals) {
                    foreach ($relatedDeals as $deal) {
                        if ($deal['pid'] != $productId && $count < 4) {
                            $count++;
                ?>
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card h-100 shadow-sm border-0">
                            <img src="<?php echo htmlspecialchars_decode($deal['product_image']); ?>" 
                                 alt="<?php echo sanitizeOutput($deal['product_name']); ?>" 
                                 class="card-img-top"
                                 style="height: 200px; object-fit: cover;">
                            
                            <div class="card-body d-flex flex-column">
                                <h3 class="card-title h6 flex-grow-1"><?php echo sanitizeOutput($deal['product_name']); ?></h3>
                                
                                <div class="pricing-info mb-3">
                                    <div class="text-success fw-bold"><?php echo formatPrice($deal['product_offer_price']); ?></div>
                                    <small class="text-muted text-decoration-line-through"><?php echo formatPrice($deal['product_sale_price']); ?></small>
                                </div>
                                
                                <a href="<?php echo SITE_URL; ?>/product/<?php echo $deal['pid']; ?>/<?php echo generateSlug($deal['product_name']); ?>" data-product-id="<?php echo $deal['pid']; ?>" title="View details for <?php echo sanitizeOutput($deal['product_name']); ?>" class="btn btn-outline-primary btn-sm mt-auto">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                <?php
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
// Product tracking
function trackProductClick(productId) {
    // You can add Google Analytics or other tracking here
    console.log('Product purchased:', productId);
    
    // Example: Send to Google Analytics
    if (typeof gtag !== 'undefined') {
        gtag('event', 'purchase', {
            'transaction_id': productId,
            'currency': 'INR'
        });
    }
}

// Social Sharing Functions
const shareData = {
    title: "<?php echo addslashes($product['product_name']); ?>",
    description: "🔥 Amazing deal on <?php echo addslashes($product['product_name']); ?> - Only ₹<?php echo $product['product_offer_price']; ?>! Save ₹<?php echo $savings; ?> (<?php echo $discountPercent; ?>% OFF). Limited time offer!",
    url: "<?php echo $canonicalUrl; ?>",
    image: "<?php echo htmlspecialchars_decode($product['product_image']); ?>",
    hashtags: ["deals<?php echo $currentYear; ?>", "shopping", "offers", "discount", "<?php echo strtolower(str_replace(' ', '', $product['store_name'])); ?>"]
};

function shareOnFacebook() {
    const url = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareData.url)}&quote=${encodeURIComponent(shareData.description)}`;
    openShareWindow(url, 'Facebook');
    trackSocialShare('facebook');
}

function shareOnTwitter() {
    const text = `${shareData.description} #${shareData.hashtags.join(' #')}`;
    const url = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(shareData.url)}`;
    openShareWindow(url, 'Twitter');
    trackSocialShare('twitter');
}

function shareOnWhatsApp() {
    const text = `${shareData.description}\n\n👉 ${shareData.url}`;
    const url = `https://wa.me/?text=${encodeURIComponent(text)}`;
    
    // For mobile devices, try to open WhatsApp app
    if (/Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        window.open(url, '_blank');
    } else {
        openShareWindow(url, 'WhatsApp');
    }
    trackSocialShare('whatsapp');
}

function shareOnTelegram() {
    const url = `https://t.me/share/url?url=${encodeURIComponent(shareData.url)}&text=${encodeURIComponent(shareData.description)}`;
    openShareWindow(url, 'Telegram');
    trackSocialShare('telegram');
}

function shareOnLinkedIn() {
    const url = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(shareData.url)}`;
    openShareWindow(url, 'LinkedIn');
    trackSocialShare('linkedin');
}

function shareOnPinterest() {
    const url = `https://pinterest.com/pin/create/button/?url=${encodeURIComponent(shareData.url)}&media=${encodeURIComponent(shareData.image)}&description=${encodeURIComponent(shareData.description)}`;
    openShareWindow(url, 'Pinterest');
    trackSocialShare('pinterest');
}

function shareOnReddit() {
    const url = `https://reddit.com/submit?url=${encodeURIComponent(shareData.url)}&title=${encodeURIComponent(shareData.title)}`;
    openShareWindow(url, 'Reddit');
    trackSocialShare('reddit');
}

function shareViaEmail() {
    const subject = `Check out this amazing deal: ${shareData.title}`;
    const body = `Hi!\n\nI found this amazing deal and thought you might be interested:\n\n${shareData.description}\n\nCheck it out here: ${shareData.url}\n\nHappy shopping!\n`;
    const url = `mailto:?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
    window.location.href = url;
    trackSocialShare('email');
}

function copyToClipboard() {
    const textToCopy = `${shareData.description}\n\n${shareData.url}`;
    
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(textToCopy).then(() => {
            showCopySuccess();
        }).catch(() => {
            fallbackCopyTextToClipboard(textToCopy);
        });
    } else {
        fallbackCopyTextToClipboard(textToCopy);
    }
    trackSocialShare('copy');
}

function fallbackCopyTextToClipboard(text) {
    const textArea = document.createElement("textarea");
    textArea.value = text;
    textArea.style.top = "0";
    textArea.style.left = "0";
    textArea.style.position = "fixed";
    
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    
    try {
        document.execCommand('copy');
        showCopySuccess();
    } catch (err) {
        console.error('Fallback: Oops, unable to copy', err);
        alert('Unable to copy to clipboard. Please copy the URL manually: ' + shareData.url);
    }
    
    document.body.removeChild(textArea);
}

function showCopySuccess() {
    const originalBtn = event.target.closest('.share-btn');
    const originalContent = originalBtn.innerHTML;
    
    originalBtn.innerHTML = '<i class="bi bi-check-circle-fill"></i> Copied!';
    originalBtn.classList.add('btn-success');
    originalBtn.classList.remove('btn-copy');
    
    setTimeout(() => {
        originalBtn.innerHTML = originalContent;
        originalBtn.classList.remove('btn-success');
        originalBtn.classList.add('btn-copy');
    }, 2000);
}

function printPage() {
    window.print();
    trackSocialShare('print');
}

function openShareWindow(url, platform) {
    const width = 550;
    const height = 420;
    const left = (screen.width - width) / 2;
    const top = (screen.height - height) / 2;
    
    window.open(
        url,
        `share-${platform}`,
        `width=${width},height=${height},left=${left},top=${top},scrollbars=yes,resizable=yes`
    );
}

function trackSocialShare(platform) {
    // Track social shares for analytics
    console.log(`Shared on ${platform}:`, shareData.title);
    
    // Google Analytics tracking
    if (typeof gtag !== 'undefined') {
        gtag('event', 'share', {
            'method': platform,
            'content_type': 'product',
            'item_id': '<?php echo $product['pid']; ?>'
        });
    }
    
    // Facebook Pixel tracking
    if (typeof fbq !== 'undefined') {
        fbq('track', 'Share', {
            content_name: shareData.title,
            content_category: 'product'
        });
    }
}

// Native Web Share API support
if (navigator.share) {
    // Add native share button for supported browsers
    const nativeShareHtml = `
        <button class="btn btn-primary share-btn" onclick="nativeShare()" style="order: -1;">
            <i class="bi bi-share-fill"></i> Share
        </button>
    `;
    document.querySelector('.social-sharing .d-flex').insertAdjacentHTML('afterbegin', nativeShareHtml);
}

async function nativeShare() {
    try {
        await navigator.share({
            title: shareData.title,
            text: shareData.description,
            url: shareData.url
        });
        trackSocialShare('native');
    } catch (err) {
        console.log('Error sharing:', err);
    }
}
</script>

<?php include 'includes/footer.php'; ?>