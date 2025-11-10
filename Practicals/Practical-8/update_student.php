<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($conn) {
        $id = intval($_POST['student_id']);
        $year = intval($_POST['year']);

        $sql = "UPDATE students SET year=$year WHERE student_id=$id";

        if ($conn->query($sql) === TRUE) {
            echo "<p style='color:green;'>Student Year Updated!</p>";
        } else {
            echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color:red;'>Database connection failed!</p>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Update Student | 24CE070</title>
  <style>
    .header { background: #FF9800; color: white; padding: 15px; margin: -20px -20px 20px -20px; }
    .student-info { font-size: 14px; margin-top: 5px; }
  </style>
</head>
<body style="font-family: Arial; padding:20px; background:#f9f9f9;">
  <div class="header">
    <h2 style="margin: 0;">Update Student Information</h2>
    <div class="student-info">Student ID: 24CE070 | Practical 8: MySQL Update Operations</div>
  </div>
  <form method="POST" action="">
    Student ID: <input type="number" name="student_id" required><br><br>
    New Year: <input type="number" name="year" required><br><br>
    <button type="submit">Update</button>
  </form>
  <br>
  <a href="index.php">Back to List</a>
</body>
</html>
