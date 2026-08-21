mobile
<?php
header('Content-Type: text/plain');
echo "=== DEBUG INFO ===\n\n";
echo "User-Agent: " . $_SERVER['HTTP_USER_AGENT'] . "\n";
echo "Query String: " . ($_SERVER['QUERY_STRING'] ?? 'EMPTY') . "\n";
echo "Request URI: " . $_SERVER['REQUEST_URI'] . "\n";
echo "\n=== CHECKS ===\n";
echo "Has 'callfrom=app': " . (strpos($_SERVER['QUERY_STRING'] ?? '', 'callfrom=app') !== false ? 'YES' : 'NO') . "\n";
echo "Is Mobile UA: " . (preg_match('/android|iphone|ipad|mobile/i', $_SERVER['HTTP_USER_AGENT']) ? 'YES' : 'NO') . "\n";
?>
