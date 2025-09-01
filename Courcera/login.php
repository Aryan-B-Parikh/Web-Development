<title>Aryan Parikh e8d21e55</title>
<?php
session_start();

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1'; // md5(salt + "php123")
$error = '';

if (isset($_POST['who']) && isset($_POST['pass'])) {
    unset($_SESSION['name']); // clear session on login attempt

    $name = trim($_POST['who']);
    $pass = $_POST['pass'];

    if (strlen($name) < 1 || strlen($pass) < 1) {
        $error = "User name and password are required";
    } else {
        $check = hash('md5', $salt . $pass);
        if ($check === $stored_hash) {
            $_SESSION['name'] = $name;
            header("Location: game.php?name=" . urlencode($name));
            return;
        } else {
            $error = "Incorrect password";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Aryan Parikh e8d21e55</title></head>
<body>
<h1>Please Log In</h1>
<?php
if ($error !== '') {
    echo('<p style="color:red;">' . htmlentities($error) . "</p>\n");
}
?>
<form method="post">
<label for="nam">User Name</label>
<input type="text" name="who" id="nam"><br/><br/>
<label for="id_1723">Password</label>
<input type="password" name="pass" id="id_1723"><br/><br/>
<input type="submit" value="Log In">
</form>
</body>
</html>
