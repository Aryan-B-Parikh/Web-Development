<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <form method="post">
    Enter your name:
    <input type="text" name="firstname" placeholder="Aryan"><br><br>
    <button type="submit">Submit</button>
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"]=="POST")
    {
        $name = $_POST["firstname"];
        echo "Hello ". $name ."!";
    }
    ?>
</body>
</html>