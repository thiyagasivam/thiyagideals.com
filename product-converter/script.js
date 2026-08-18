// DOM Elements
const dealInput = document.getElementById('dealInput');
const convertBtn = document.getElementById('convertBtn');
const resetBtn = document.getElementById('resetBtn');
const pageShareBtn = document.getElementById('pageShareBtn');
const resultSection = document.getElementById('resultSection');
const resultOutput = document.getElementById('resultOutput');
const closeResultBtn = document.getElementById('closeResultBtn');
const openLinkBtn = document.getElementById('openLinkBtn');
const copyBtn = document.getElementById('copyBtn');
const shareBtn = document.getElementById('shareBtn');
const loading = document.getElementById('loading');
const errorMessage = document.getElementById('errorMessage');

// API Configuration
const API_ENDPOINT = 'converter';

// Event Listeners
convertBtn.addEventListener('click', handleConvert);
resetBtn.addEventListener('click', handleReset);
pageShareBtn.addEventListener('click', handlePageShare);
closeResultBtn.addEventListener('click', closeResult);
openLinkBtn.addEventListener('click', handleOpenLink);
copyBtn.addEventListener('click', copyToClipboard);
shareBtn.addEventListener('click', handleShare);



// Main conversion function
async function handleConvert() {
    const dealContent = dealInput.value.trim();

    if (!dealContent) {
        showError('Please paste affiliate links in the input area');
        return;
    }

    const convertOption = 'convert_only';

    // Show loading state
    setLoading(true);
    hideError();

    try {
        const response = await fetch(API_ENDPOINT, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                deal: dealContent,
                convert_option: convertOption
            })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();

        if (data.success) {
            displayResult(data.result);
        } else {
            showError(data.message || 'Conversion failed. Please try again.');
        }
    } catch (error) {
        console.error('Error:', error);
        showError('An error occurred while converting links. Please check your connection and try again.');
    } finally {
        setLoading(false);
    }
}

// Display result
function displayResult(result) {
    resultOutput.value = result;
    resultSection.classList.remove('hidden');
    // Scroll to result
    resultSection.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

// Close result
function closeResult() {
    resultSection.classList.add('hidden');
}

// Reset form
function handleReset() {
    dealInput.value = '';
    resultSection.classList.add('hidden');
    dealInput.focus();
    hideError();
}

// Open link in new tab
function handleOpenLink() {
    if (!resultOutput.value) return;

    // Extract the first URL from the result
    const urlRegex = /(https?:\/\/[^\s]+)/;
    const match = resultOutput.value.match(urlRegex);

    if (match && match[1]) {
        window.open(match[1], '_blank');
    } else {
        showError('No valid URL found in the converted links');
    }
}

// Copy to clipboard
function copyToClipboard() {
    if (!resultOutput.value) return;

    resultOutput.select();
    document.execCommand('copy');

    // Show feedback
    const originalText = copyBtn.textContent;
    copyBtn.textContent = 'Copied!';
    setTimeout(() => {
        copyBtn.textContent = originalText;
    }, 2000);
}

// Share functionality
function handleShare() {
    if (!resultOutput.value) return;

    const text = resultOutput.value;
    const title = 'Converted Affiliate Links';

    // Check if Web Share API is available
    if (navigator.share) {
        navigator.share({
            title: title,
            text: text
        }).catch(error => {
            if (error.name !== 'AbortError') {
                console.error('Error sharing:', error);
            }
        });
    } else {
        // Fallback: Open social media share options
        showShareMenu(text);
    }
}

// Show share menu (fallback for browsers without Web Share API)
function showShareMenu(text) {
    const encodedText = encodeURIComponent(text);
    const encodedUrl = encodeURIComponent(window.location.href);
    
    const shareOptions = `
        <div class="share-menu">
            <a href="https://www.facebook.com/sharer/sharer.php?u=${encodedUrl}" target="_blank" rel="noopener">Facebook</a>
            <a href="https://twitter.com/intent/tweet?text=${encodedText}" target="_blank" rel="noopener">Twitter</a>
            <a href="https://www.linkedin.com/sharing/share-offsite/?url=${encodedUrl}" target="_blank" rel="noopener">LinkedIn</a>
            <a href="mailto:?subject=Converted Affiliate Links&body=${encodedText}" target="_blank" rel="noopener">Email</a>
        </div>
    `;
    
    // Create a temporary div for share menu
    const shareMenu = document.createElement('div');
    shareMenu.innerHTML = shareOptions;
    shareMenu.className = 'share-menu-container';
    
    // Position it near the share button
    shareBtn.parentElement.appendChild(shareMenu);
    
    // Remove after a delay
    setTimeout(() => {
        shareMenu.remove();
    }, 5000);
}

// Show loading spinner
function setLoading(isLoading) {
    if (isLoading) {
        loading.classList.remove('hidden');
        convertBtn.disabled = true;
    } else {
        loading.classList.add('hidden');
        convertBtn.disabled = false;
    }
}

// Show error message
function showError(message) {
    errorMessage.textContent = message;
    errorMessage.classList.remove('hidden');
    // Auto-hide after 5 seconds
    setTimeout(() => {
        hideError();
    }, 5000);
}

// Hide error message
function hideError() {
    errorMessage.classList.add('hidden');
}

// Handle page share
function handlePageShare() {
    const pageTitle = 'Converter - ThiyagiDeals';
    const pageUrl = window.location.href;
    const pageDescription = 'Convert your affiliate links easily with our powerful converter tool.';

    // Check if Web Share API is available
    if (navigator.share) {
        navigator.share({
            title: pageTitle,
            text: pageDescription,
            url: pageUrl
        }).catch(error => {
            if (error.name !== 'AbortError') {
                console.error('Error sharing:', error);
            }
        });
    } else {
        // Fallback: Show share options menu
        showPageShareMenu(pageUrl, pageTitle, pageDescription);
    }
}

// Show page share menu (fallback for browsers without Web Share API)
function showPageShareMenu(url, title, description) {
    const encodedUrl = encodeURIComponent(url);
    const encodedTitle = encodeURIComponent(title);
    const encodedDescription = encodeURIComponent(description);
    
    const shareOptions = `
        <div class="page-share-menu">
            <a href="https://www.facebook.com/sharer/sharer.php?u=${encodedUrl}" target="_blank" rel="noopener" class="share-option facebook">
                <span>Facebook</span>
            </a>
            <a href="https://twitter.com/intent/tweet?url=${encodedUrl}&text=${encodedTitle}" target="_blank" rel="noopener" class="share-option twitter">
                <span>Twitter</span>
            </a>
            <a href="https://www.linkedin.com/sharing/share-offsite/?url=${encodedUrl}" target="_blank" rel="noopener" class="share-option linkedin">
                <span>LinkedIn</span>
            </a>
            <a href="mailto:?subject=${encodedTitle}&body=${encodedDescription}%0A${encodedUrl}" target="_blank" rel="noopener" class="share-option email">
                <span>Email</span>
            </a>
        </div>
    `;
    
    // Remove any existing share menu
    const existingMenu = document.querySelector('.page-share-menu-container');
    if (existingMenu) existingMenu.remove();
    
    // Create a temporary div for share menu
    const shareMenuContainer = document.createElement('div');
    shareMenuContainer.innerHTML = shareOptions;
    shareMenuContainer.className = 'page-share-menu-container';
    
    // Position it near the share button
    pageShareBtn.parentElement.appendChild(shareMenuContainer);
    
    // Remove after a delay
    setTimeout(() => {
        shareMenuContainer.remove();
    }, 5000);
}


