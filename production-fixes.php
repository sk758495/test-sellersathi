<?php
// Add this to your bootstrap/app.php or config/app.php for production

// Production timeout settings
ini_set('max_execution_time', 300);
ini_set('default_socket_timeout', 180);
ini_set('mysql.connect_timeout', 60);
ini_set('session.gc_maxlifetime', 14400);

// cURL settings for production
if (function_exists('curl_init')) {
    // Set global cURL defaults
    $curlDefaults = [
        CURLOPT_TIMEOUT => 180,
        CURLOPT_CONNECTTIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_MAXREDIRS => 3,
        CURLOPT_USERAGENT => 'Laravel Payment Gateway',
        CURLOPT_DNS_CACHE_TIMEOUT => 300,
        CURLOPT_TCP_KEEPALIVE => 1
    ];
    
    // Apply to all cURL requests
    foreach ($curlDefaults as $option => $value) {
        curl_setopt_array(curl_init(), [$option => $value]);
    }
}

// Memory and time limits for payment processing
if (request()->is('*/payment/*') || request()->is('*/hdfc/*')) {
    ini_set('max_execution_time', 600);
    ini_set('memory_limit', '1024M');
    set_time_limit(600);
}
?>