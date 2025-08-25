<?php
if (isset($_GET["limit"])) {
    $limit = (int)$_GET["limit"]; // Cast to integer for security
    if ($limit < 1) {
        $limit = 5;
    }
} else {
    $limit = 5;
}

$url = "https://dummyjson.com/quotes?limit=$limit";
$json_content = file_get_contents($url);
$data = json_decode($json_content, true);

$quotes = $data['quotes'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Random Quotes</title>
</head>
<body>
    <h1>Random Quotes (Limit: <?php echo $limit; ?>)</h1>
    <?php if (!empty($quotes)): ?>
        <?php foreach ($quotes as $quote): ?>
            <div class="quote">
                <p class="quote-text">"<?php echo htmlspecialchars($quote['quote']); ?>"</p>
                <p class="author">— <?php echo htmlspecialchars($quote['author']); ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No quotes found.</p>
    <?php endif; ?>
</body>
</html>