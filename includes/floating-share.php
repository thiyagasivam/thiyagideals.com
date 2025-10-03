<!-- Floating Social Share Widget -->
<div id="floating-share-widget" class="floating-share-widget" style="display: none;">
    <div class="floating-share-toggle" onclick="toggleFloatingShare()">
        <i class="bi bi-share-fill"></i>
    </div>
    <div class="floating-share-buttons">
        <button class="floating-share-btn facebook" onclick="quickShare('facebook')" title="Share on Facebook">
            <i class="bi bi-facebook"></i>
        </button>
        <button class="floating-share-btn twitter" onclick="quickShare('twitter')" title="Share on Twitter">
            <i class="bi bi-twitter"></i>
        </button>
        <button class="floating-share-btn whatsapp" onclick="quickShare('whatsapp')" title="Share on WhatsApp">
            <i class="bi bi-whatsapp"></i>
        </button>
        <button class="floating-share-btn telegram" onclick="quickShare('telegram')" title="Share on Telegram">
            <i class="bi bi-telegram"></i>
        </button>
        <button class="floating-share-btn copy" onclick="quickCopy()" title="Copy Link">
            <i class="bi bi-clipboard"></i>
        </button>
    </div>
</div>

<style>
.floating-share-widget {
    position: fixed;
    right: 20px;
    bottom: 20px;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}

.floating-share-toggle {
    width: 56px;
    height: 56px;
    background: linear-gradient(135deg, #2874f0, #4285f4);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
    cursor: pointer;
    box-shadow: 0 4px 16px rgba(40, 116, 240, 0.3);
    transition: all 0.3s ease;
    animation: pulse-float 2s infinite;
}

.floating-share-toggle:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(40, 116, 240, 0.4);
}

@keyframes pulse-float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-3px); }
}

.floating-share-buttons {
    display: flex;
    flex-direction: column;
    gap: 8px;
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.3s ease;
    pointer-events: none;
}

.floating-share-buttons.active {
    opacity: 1;
    transform: translateY(0);
    pointer-events: all;
}

.floating-share-btn {
    width: 44px;
    height: 44px;
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}

.floating-share-btn:hover {
    transform: scale(1.1);
}

.floating-share-btn.facebook { background: #1877f2; }
.floating-share-btn.twitter { background: #1da1f2; }
.floating-share-btn.whatsapp { background: #25d366; }
.floating-share-btn.telegram { background: #0088cc; }
.floating-share-btn.copy { background: #6c757d; }

/* Mobile adjustments */
@media (max-width: 768px) {
    .floating-share-widget {
        right: 15px;
        bottom: 15px;
    }
    
    .floating-share-toggle {
        width: 50px;
        height: 50px;
        font-size: 18px;
    }
    
    .floating-share-btn {
        width: 40px;
        height: 40px;
        font-size: 14px;
    }
}
</style>

<script>
let floatingShareExpanded = false;

function toggleFloatingShare() {
    const buttons = document.querySelector('.floating-share-buttons');
    const toggle = document.querySelector('.floating-share-toggle');
    
    if (floatingShareExpanded) {
        buttons.classList.remove('active');
        toggle.innerHTML = '<i class="bi bi-share-fill"></i>';
        floatingShareExpanded = false;
    } else {
        buttons.classList.add('active');
        toggle.innerHTML = '<i class="bi bi-x"></i>';
        floatingShareExpanded = true;
    }
}

function quickShare(platform) {
    const currentPage = window.location.href;
    const title = document.title;
    const description = document.querySelector('meta[name="description"]')?.content || title;
    
    let url = '';
    
    switch(platform) {
        case 'facebook':
            url = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(currentPage)}`;
            break;
        case 'twitter':
            url = `https://twitter.com/intent/tweet?text=${encodeURIComponent(title)}&url=${encodeURIComponent(currentPage)}`;
            break;
        case 'whatsapp':
            url = `https://wa.me/?text=${encodeURIComponent(title + '\n\n' + currentPage)}`;
            break;
        case 'telegram':
            url = `https://t.me/share/url?url=${encodeURIComponent(currentPage)}&text=${encodeURIComponent(title)}`;
            break;
    }
    
    if (url) {
        window.open(url, '_blank', 'width=550,height=420');
    }
    
    // Close the floating widget after sharing
    toggleFloatingShare();
}

function quickCopy() {
    const currentPage = window.location.href;
    
    if (navigator.clipboard) {
        navigator.clipboard.writeText(currentPage).then(() => {
            showQuickCopySuccess();
        });
    } else {
        // Fallback
        const textArea = document.createElement("textarea");
        textArea.value = currentPage;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        showQuickCopySuccess();
    }
    
    toggleFloatingShare();
}

function showQuickCopySuccess() {
    const toggle = document.querySelector('.floating-share-toggle');
    const originalContent = toggle.innerHTML;
    
    toggle.innerHTML = '<i class="bi bi-check"></i>';
    toggle.style.background = '#28a745';
    
    setTimeout(() => {
        toggle.innerHTML = originalContent;
        toggle.style.background = '';
    }, 2000);
}

// Show/hide floating widget based on scroll
window.addEventListener('scroll', function() {
    const widget = document.getElementById('floating-share-widget');
    const scrollPosition = window.scrollY;
    
    if (scrollPosition > 300) {
        widget.style.display = 'flex';
    } else {
        widget.style.display = 'none';
        if (floatingShareExpanded) {
            toggleFloatingShare();
        }
    }
});
</script>