<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Event | 24CE070</title>
    <style>
        .header { background: #4CAF50; color: white; padding: 15px; margin: -20px -20px 20px -20px; }
        .student-info { font-size: 14px; margin-top: 5px; }
        body { font-family: Arial; padding: 20px; background: #f9f9f9; }
        .form-container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        input, select { padding: 8px; width: 100%; margin: 5px 0 15px 0; }
        input[type="submit"] { background: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
<div class="header">
    <h2 style="margin: 0;">Add New Event</h2>
    <div class="student-info">Student ID: 24CE070 | Practical 12: File Upload & Database Operations</div>
</div>

<div class="form-container">
    <form method="POST" enctype="multipart/form-data">
        <label>Event Title:</label><br>
        <input type="text" name="title" required><br>
        
        <label>Event Date:</label><br>
        <input type="date" name="date" required><br>
        
        <label>Location:</label><br>
        <input type="text" name="location" required><br>
        
        <label>Status:</label><br>
        <select name="status">
            <option value="open">Open</option>
            <option value="closed">Closed</option>
        </select><br>
        
        <label>Event Poster:</label><br>
        <input type="file" name="poster" accept="image/*"><br>
        
        <input type="submit" name="submit" value="Save Event">
    </form>
</div>

<?php
if (isset($_POST['submit'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $date = $_POST['date'];
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $status = $_POST['status'];
    
    $poster = null;
    if (!empty($_FILES['poster']['name'])) {
        // Create student-specific upload directory
        $upload_dir = "upload_24ce070/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $poster = "24ce070_" . time() . "_" . $_FILES['poster']['name'];
        $upload_path = $upload_dir . $poster;
        
        if (move_uploaded_file($_FILES['poster']['tmp_name'], $upload_path)) {
            // Log file upload for student 24CE070
            $log_entry = "[" . date('Y-m-d H:i:s') . "] File uploaded by 24CE070: $poster\n";
            file_put_contents("upload_log_24ce070.txt", $log_entry, FILE_APPEND);
        }
    }

    $sql = "INSERT INTO events (title,date,location,status,poster) 
            VALUES ('$title','$date','$location','$status','$poster')";

    if ($conn->query($sql)) {
        echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 15px 0;'>";
        echo "<strong>Success!</strong> Event added successfully by Student 24CE070!";
        echo "</div>";
        echo "<a href='index.php' style='background: #2196F3; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px;'>View All Events</a>";
    } else {
        echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 15px 0;'>";
        echo "<strong>Error:</strong> " . $conn->error;
        echo "</div>";
    }
}
?>
</body>
</html>
