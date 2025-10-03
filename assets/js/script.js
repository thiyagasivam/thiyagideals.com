// Main JavaScript functionality
document.addEventListener('DOMContentLoaded', function() {
    // Product card interactions
    const productCards = document.querySelectorAll('.product-card');
    
    productCards.forEach(card => {
        card.addEventListener('click', function(e) {
            if (!e.target.classList.contains('view-details-btn')) {
                const link = this.querySelector('a');
                if (link) {
                    window.location.href = link.href;
                }
            }
        });
    });
    
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
    
    // Add to cart functionality (can be extended)
    const buyButtons = document.querySelectorAll('.buy-now-btn, .view-details-btn');
    buyButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            // Track click event for analytics
            console.log('Product clicked:', this.dataset.productId || 'Unknown');
        });
    });
});

// Utility functions
function formatPrice(price) {
    return '₹' + parseInt(price).toLocaleString('en-IN');
}

function calculateDiscount(original, sale) {
    const discount = ((original - sale) / original) * 100;
    return Math.round(discount) + '% OFF';
}