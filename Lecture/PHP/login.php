<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="POST">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="password" placeholder="Password">
        <input type="submit" name="login">
        <button type="reset">Reset</button>
        <?php 
        
        if(isset($_POST["login"])) {
            $unamee = $_REQUEST["username"];
            $psd = $_REQUEST["password"];
            echo "NAME: " . $unamee . " PASSWORD: " . htmlspecialchars($psd) . ""; 
        }
        ?>
    </form>
</body>

</html>