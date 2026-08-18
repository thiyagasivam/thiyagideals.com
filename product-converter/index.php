<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Affiliate Converter</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <div class="header-container">
                <div class="header-left">
                    <div class="logo-placeholder">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none">
                            <rect width="40" height="40" rx="8" fill="#1db854"/>
                            <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-size="20" font-weight="bold" fill="white" font-family="Arial">TD</text>
                        </svg>
                    </div>
                    <div class="site-info">
                        <h1>Product Converter</h1>
                        <p class="site-name">thiyagideals</p>
                    </div>
                </div>
                <button id="pageShareBtn" class="page-share-btn" title="Share this page">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="18" cy="5" r="3"></circle>
                        <circle cx="6" cy="12" r="3"></circle>
                        <circle cx="18" cy="19" r="3"></circle>
                        <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                        <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                    </svg>
                </button>
            </div>
        </header>

        <main>
            <div class="form-section">
                <textarea 
                    id="dealInput" 
                    class="input-area" 
                    placeholder="Paste your Products links here"
                    rows="8"
                ></textarea>



                <div class="button-group">
                    <button id="convertBtn" class="convert-btn">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="17 1 21 5 17 9"></polyline>
                            <path d="M3 11V9a4 4 0 0 1 4-4h14"></path>
                            <polyline points="7 23 3 19 7 15"></polyline>
                            <path d="M21 13v2a4 4 0 0 1-4 4H3"></path>
                        </svg>
                        Convert
                    </button>
                    <button id="resetBtn" class="reset-btn">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"></path>
                            <path d="M21 3v5h-5"></path>
                            <path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"></path>
                            <path d="M3 21v-5h5"></path>
                        </svg>
                        Reset
                    </button>
                </div>
            </div>

            <div id="resultSection" class="result-section hidden">
                <div class="result-header">
                    <h2>Converted Links</h2>
                    <button id="closeResultBtn" class="close-btn">✕</button>
                </div>
                <textarea 
                    id="resultOutput" 
                    class="output-area" 
                    readonly
                    rows="8"
                ></textarea>
                <div class="result-button-group">
                    <button id="openLinkBtn" class="open-link-btn" title="Open first link">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                            <polyline points="15 3 21 3 21 9"></polyline>
                            <line x1="10" y1="14" x2="21" y2="3"></line>
                        </svg>
                        Open Link
                    </button>
                    <button id="copyBtn" class="copy-btn">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                        </svg>
                        Copy to Clipboard
                    </button>
                    <button id="shareBtn" class="share-btn" title="Share on social media">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="18" cy="5" r="3"></circle>
                            <circle cx="6" cy="12" r="3"></circle>
                            <circle cx="18" cy="19" r="3"></circle>
                            <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                            <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                        </svg>
                        Share
                    </button>
                </div>
            </div>

            <div id="loading" class="loading hidden">
                <div class="spinner"></div>
                <p>Converting links...</p>
            </div>

            <div id="errorMessage" class="error-message hidden"></div>

            <!-- Steps Section -->
            <div class="steps-section">
                <h2 class="steps-title">How to Use</h2>
                <div class="steps-container">
                    <div class="step-card">
                        <div class="step-number">1</div>
                        <div class="step-icon">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                            </svg>
                        </div>
                        <h3>Product Link Copied</h3>
                        <p>Copy your product link from the source</p>
                    </div>

                    <div class="step-arrow">→</div>

                    <div class="step-card">
                        <div class="step-number">2</div>
                        <div class="step-icon">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"></path>
                            </svg>
                        </div>
                        <h3>Paste the Link</h3>
                        <p>Paste your link in the input field below</p>
                    </div>

                    <div class="step-arrow">→</div>

                    <div class="step-card">
                        <div class="step-number">3</div>
                        <div class="step-icon">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="17 1 21 5 17 9"></polyline>
                                <path d="M3 11V9a4 4 0 0 1 4-4h14"></path>
                                <polyline points="7 23 3 19 7 15"></polyline>
                                <path d="M21 13v2a4 4 0 0 1-4 4H3"></path>
                            </svg>
                        </div>
                        <h3>Convert Link</h3>
                        <p>Click the Convert button to transform your link</p>
                    </div>

                    <div class="step-arrow">→</div>

                    <div class="step-card">
                        <div class="step-number">4</div>
                        <div class="step-icon">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                <polyline points="15 3 21 3 21 9"></polyline>
                                <line x1="10" y1="14" x2="21" y2="3"></line>
                            </svg>
                        </div>
                        <h3>Share & Open</h3>
                        <p>Open the link or share it on social media</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>
