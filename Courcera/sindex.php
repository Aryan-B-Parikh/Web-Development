<?php
$input_hash = $_GET['md5'] ?? '';

if (empty($input_hash)) {
    echo "Please enter an MD5 hash.";
    exit;
}

$start = microtime(true);
$found = false;
$attempts = 0;

for ($i = 0; $i <= 9999; $i++) {
    $pin = str_pad($i, 4, '0', STR_PAD_LEFT);
    $try_hash = hash('md5', $pin);

    if ($attempts < 15) {
        echo "Trying PIN $pin with hash $try_hash<br>\n";
    }

    if ($try_hash === strtolower($input_hash)) {
        echo "PIN: $pin<br>\n";
        $found = true;
        break;
    }
    $attempts++;
}

if (!$found) {
    echo "PIN: Not found<br>\n";
}

$end = microtime(true);
$elapsed = $end - $start;
echo "Elapsed time: $elapsed seconds";
?>