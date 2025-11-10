<?php include("db.php"); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Management | 24CE070</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .header { background: #9C27B0; color: white; padding: 15px; margin: -20px -20px 20px -20px; }
        .student-info { font-size: 14px; margin-top: 5px; }
        .search-section { background: #F3E5F5; padding: 15px; border-radius: 8px; margin: 15px 0; }
    </style>
</head>
<body>
<div class="header">
    <h2 style="margin: 0;">Student Management System</h2>
    <div class="student-info">Student ID: 24CE070 | Practical 11: Search, Insert & Delete Operations</div>
</div>

<div class="search-section">
    <h3>Search Student</h3>
    <form method="POST">
        <input type="text" name="search" placeholder="Enter student name to search" style="padding: 8px; width: 300px;">
        <button type="submit" style="padding: 8px 15px; background: #9C27B0; color: white; border: none; border-radius: 4px;">Search</button>
    </form>
</div>

<h2>Student List</h2>
<table border="1">
<tr><th>ID</th><th>Name</th><th>Age</th><th>Department</th><th>Action</th></tr>

<?php
$search = "";
if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $sql = "SELECT * FROM students WHERE name LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM students";
}

$result = mysqli_query($conn, $sql);

while($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>".$row['id']."</td>
            <td>".$row['name']."</td>
            <td>".$row['age']."</td>
            <td>".$row['department_id']."</td>
            <td><a href='delete.php?id=".$row['id']."'>Delete</a></td>
          </tr>";
}
?>
</table>

<br>
<a href="insert.php">➕ Add New Student</a>

</body>
</html>
