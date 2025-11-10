<?php include("db.php"); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Insert Student | 24CE070</title>
    <style>
        .header { background: #4CAF50; color: white; padding: 15px; margin: -20px -20px 20px -20px; }
        .student-info { font-size: 14px; margin-top: 5px; }
        .form-container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        body { font-family: Arial; padding: 20px; background: #f9f9f9; }
    </style>
</head>
<body>
<div class="header">
    <h2 style="margin: 0;">Add New Student</h2>
    <div class="student-info">Student ID: 24CE070 | Practical 11: Database Insert Operations</div>
</div>

<div class="form-container">
    <form method="POST">
        <label>Name:</label><br>
        <input type="text" name="name" required style="padding: 8px; width: 100%; margin: 5px 0 15px 0;"><br>
        
        <label>Age:</label><br>
        <input type="number" name="age" required style="padding: 8px; width: 100%; margin: 5px 0 15px 0;"><br>
        
        <label>Department ID:</label><br>
        <input type="number" name="dept_id" required style="padding: 8px; width: 100%; margin: 5px 0 15px 0;"><br>
        
        <button type="submit" name="insert" style="background: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Insert Student</button>
    </form>
</div>

<?php
if (isset($_POST['insert'])) {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $dept = $_POST['dept_id'];

    $sql = "INSERT INTO students (name, age, department_id) VALUES ('$name', '$age', '$dept')";
    if (mysqli_query($conn, $sql)) {
        echo "<p>✅ Student inserted successfully!</p>";
    } else {
        echo "❌ Error: " . mysqli_error($conn);
    }
}
?>
<br>
<a href="index.php">⬅ Back to Student List</a>
</body>
</html>
