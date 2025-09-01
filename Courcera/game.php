<title>Aryan Parikh e8d21e55</title>
<?php
session_start();

if (!isset($_SESSION['name'])) {
    die("Name parameter missing");
}

$names = array("Rock", "Paper", "Scissors");

function check($computer, $human) {
    if ($computer == $human) return "Tie";
    elseif (($human == 0 && $computer == 2) ||
            ($human == 1 && $computer == 0) ||
            ($human == 2 && $computer == 1)) {
        return "You Win";
    } else {
        return "You Lose";
    }
}

$user = $_SESSION['name'];
$result = '';
$computer_play = null;
$human_play = null;

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}

if (isset($_POST['play']) && isset($_POST['human'])) {
    $human_play = (int)$_POST['human'];
    if ($human_play == 3) {
        // Test all combinations
        $result = "";
        for ($c = 0; $c < 3; $c++) {
            for ($h = 0; $h < 3; $h++) {
                $r = check($c, $h);
                $result .= "Human=" . $names[$h] . " Computer=" . $names[$c] . " Result=$r<br>\n";
            }
        }
    } else {
        // Play game randomly
        $computer_play = rand(0, 2);
        $result = "Your Play=".$names[$human_play]." Computer Play=".$names[$computer_play]." Result=".check($computer_play, $human_play);
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Aryan Parikh e8d21e55</title></head>
<body>
<h1>Rock Paper Scissors</h1>
<p>Welcome: <?= htmlentities($user) ?></p>
<form method="post">
<select name="human">
<option value="0">Rock</option>
<option value="1">Paper</option>
<option value="2">Scissors</option>
<option value="3">Test</option>
</select>
<input type="submit" name="play" value="Play">
<input type="submit" name="logout" value="Logout">
</form>
<hr>
<div>
    <?= $result ?>
</div>
</body>
</html>
