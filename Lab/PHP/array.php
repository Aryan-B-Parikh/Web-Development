<?php
    $fruits = ["Apple","Banana","Cherry"];
    echo$fruits[1]."<br>";

    $student = ["Name"=>"Aryan","Age"=>"18","Grade"=>"A"];
    echo $student["Name"]."<br>";

    foreach ($student as $key => $value) {
        echo "$key : $value <br>";
    }
?>