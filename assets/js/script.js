// Main JavaScript functionality
document.addEventListener('DOMContentLoaded', function() {
    // Initialize product tracking for all pages
    initProductTracking();
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});

// Product click tracking - Non-blocking approach (shared across all pages)
function initProductTracking() {
    // Listen for clicks on all product links
    document.querySelectorAll('.view-details-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            // Don't prevent default - let link work normally
            const productId = this.getAttribute('data-product-id');
            
            // Track in background without blocking navigation
            if (typeof gtag !== 'undefined') {
                gtag('event', 'product_click', {
                    'product_id': productId,
                    'timestamp': new Date().toISOString()
                });
            }
            
            // Store for recommendations
            const productCard = this.closest('.product-card');
            if (productCard) {
                const priceElement = productCard.querySelector('.current-price');
                if (priceElement) {
                    const priceText = priceElement.textContent.replace(/[₹,]/g, '');
                    const price = parseInt(priceText);
                    storeViewedProduct(productId, price);
                }
            }
        }, { passive: true }); // Passive listener for better mobile performance
    });
}

// Store viewed product for recommendations
function storeViewedProduct(productId, price) {
    try {
        let viewedProducts = JSON.parse(localStorage.getItem('viewedProducts') || '[]');
        
        // Add new price and keep only last 10
        viewedProducts.push(price);
        viewedProducts = viewedProducts.slice(-10);
        
        localStorage.setItem('viewedProducts', JSON.stringify(viewedProducts));
    } catch(e) {
        console.log('Could not store viewed product:', e);
    }
}

// Utility functions
function formatPrice(price) {
    return '₹' + parseInt(price).toLocaleString('en-IN');
}

function calculateDiscount(original, sale) {
    const discount = ((original - sale) / original) * 100;
    return Math.round(discount) + '% OFF';
}