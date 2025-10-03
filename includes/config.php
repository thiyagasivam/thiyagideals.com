<?php
// Database configuration (if needed later)
define('DB_HOST', 'localhost');
define('DB_NAME', 'thiyagi_shop');
define('DB_USER', 'username');
define('DB_PASS', 'password');

// Earn.pe API Configuration
define('EARNPE_API_KEY', '09AA3F09-8858-4EF2-B588-9F5C0B90D449');
define('EARNPE_API_URL', 'https://earn.pe/profile/api/getDeal.php');
define('EARNPE_USER_ID', 'EP74686979616769');
define('EARNPE_TOKEN', 'F0D95996-2F9A-4362-950B-FC532F97A0CE');

// Site configuration
define('SITE_URL', 'https://thiyagideals.com');
define('SITE_NAME', 'Thiyagi Deals');

// Products display configuration
define('PRODUCTS_PER_PAGE', 30); // Increase from default API response (usually 10-12 per page)
define('API_PAGES_TO_FETCH', 3); // Number of API pages to fetch and combine

// Start session
session_start();

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>