<?php
// Set response header
header('Content-Type: application/json');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Your API Key (stored securely on server)
$API_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI2NDgxYmJhYTRhODEyZTNlNGM0NjRjZjEiLCJlYXJua2FybyI6IjI2NjUwMDgiLCJpYXQiOjE3ODY4ODgwOTB9.kr-b_3G6KUNjyUsxBkhEfualDABJQMT5BpFy0B2_i3A';
$API_ENDPOINT = 'https://ekaro-api.affiliaters.in/api/converter/public';

// Get the request body
$input = json_decode(file_get_contents('php://input'), true);

// Validate input
if (!isset($input['deal']) || !isset($input['convert_option'])) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request. Missing required fields.'
    ]);
    exit;
}

$deal = $input['deal'];
$convertOption = 'convert_only';

// Prepare curl request
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => $API_ENDPOINT,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => json_encode([
        'deal' => $deal,
        'convert_option' => $convertOption
    ]),
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer ' . $API_KEY,
        'Content-Type: application/json'
    ),
    CURLOPT_SSL_VERIFYPEER => true,
    CURLOPT_SSL_VERIFYHOST => 2
));

// Execute curl request
$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$curlError = curl_error($curl);
curl_close($curl);

// Handle curl errors
if ($curlError) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to connect to conversion service. Please try again later.'
    ]);
    error_log('Curl Error: ' . $curlError);
    exit;
}

// Handle HTTP errors
if ($httpCode !== 200) {
    http_response_code($httpCode);
    echo json_encode([
        'success' => false,
        'message' => 'Conversion service returned an error. Please try again later.'
    ]);
    error_log('API Error - Status: ' . $httpCode . ', Response: ' . $response);
    exit;
}

// Parse and return response
$apiResponse = json_decode($response, true);

if ($apiResponse) {
    // Return successful response
    echo json_encode([
        'success' => true,
        'result' => $apiResponse['data'] ?? $response
    ]);
} else {
    // If response is not JSON, return the raw response
    echo json_encode([
        'success' => true,
        'result' => $response
    ]);
}
?>
