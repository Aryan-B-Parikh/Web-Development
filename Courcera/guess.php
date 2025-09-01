<!DOCTYPE html>
<html>
<head>
    <title>Aryan Parikh e8d21e55</title>
</head>
<body>
<h1>Welcome to my guessing game</h1>
<?php
$correct = 17;

// Check if 'guess' parameter exists
if (!isset($_GET['guess'])) {
    echo "Missing guess parameter";
    return;
}

// Get the guess parameter and trim whitespace
$guess = trim($_GET['guess']);

// Check if guess is empty
if (strlen($guess) < 1) {
    echo "Your guess is too short";
    return;
}

// Check if guess is numeric
if (!is_numeric($guess)) {
    echo "Your guess is not a number";
    return;
}

// Convert guess to integer
$guess = intval($guess);

// Compare guess to correct answer
if ($guess < $correct) {
    echo "Your guess is too low";
} else if ($guess > $correct) {
    echo "Your guess is too high";
} else {
    echo "Congratulations - You are right";
}
?>
</body>
</html>
