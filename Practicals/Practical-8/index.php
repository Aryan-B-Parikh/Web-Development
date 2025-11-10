<?php
include 'db.php';

// Check if connection exists before querying
if ($conn) {
    $result = $conn->query("SELECT * FROM students");
    if (!$result) {
        die("Query failed: " . $conn->error);
    }
} else {
    die("Database connection failed. Please check your database configuration.");
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>EduTracker Pro - Students | 24CE070</title>
  <style>
    .header { 
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
      color: white; 
      padding: 20px; 
      margin: -20px -20px 25px -20px; 
      border-radius: 0 0 15px 15px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .student-info { 
      font-size: 13px; 
      margin-top: 8px; 
      opacity: 0.9;
      background: rgba(255,255,255,0.1);
      padding: 5px 10px;
      border-radius: 20px;
      display: inline-block;
    }
    .nav-buttons {
      background: white;
      padding: 15px;
      border-radius: 10px;
      margin: 15px 0;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .nav-buttons a {
      background: linear-gradient(45deg, #667eea, #764ba2);
      color: white;
      padding: 12px 20px;
      text-decoration: none;
      border-radius: 25px;
      margin-right: 10px;
      font-weight: bold;
      transition: transform 0.2s;
    }
    .nav-buttons a:hover {
      transform: translateY(-2px);
    }
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
  </style>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding:20px; background: linear-gradient(120deg, #a8edea 0%, #fed6e3 100%); min-height: 100vh;">
  <div class="header">
    <h2 style="margin: 0; font-size: 28px;">🎓 EduTracker Pro - Student Database</h2>
    <div class="student-info">👨‍🎓 Developed by: 24CE070 | Module: Advanced PHP MySQL Operations</div>
  </div>
  
  <div class="nav-buttons">
    <a href="add_student.php">➕ Register New Student</a>
    <a href="update_student.php">✏️ Modify Records</a>
  </div>

  <div style="background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
    <h3 style="color: #667eea; margin-top: 0;">📊 Current Student Records</h3>
    <table style="width: 100%; border-collapse: collapse; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
      <tr style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <th style="padding: 15px; text-align: left;">🆔 Student ID</th>
        <th style="padding: 15px; text-align: left;">👤 Full Name</th>
        <th style="padding: 15px; text-align: left;">📧 Email Address</th>
        <th style="padding: 15px; text-align: left;">📚 Course Program</th>
        <th style="padding: 15px; text-align: left;">📅 Academic Year</th>
      </tr>
    <?php 
    if ($result && $result->num_rows > 0) {
        $row_count = 0;
        while($row = $result->fetch_assoc()): 
            $row_count++;
            $bg_color = ($row_count % 2 == 0) ? '#f8f9fa' : '#ffffff';
            ?>
          <tr style="background: <?= $bg_color ?>; transition: background 0.3s;" onmouseover="this.style.background='#e3f2fd'" onmouseout="this.style.background='<?= $bg_color ?>'">
            <td style="padding: 12px; border-bottom: 1px solid #e0e0e0;"><?= $row['student_id'] ?></td>
            <td style="padding: 12px; border-bottom: 1px solid #e0e0e0; font-weight: 500;"><?= htmlspecialchars($row['name']) ?></td>
            <td style="padding: 12px; border-bottom: 1px solid #e0e0e0; color: #1976d2;"><?= htmlspecialchars($row['email']) ?></td>
            <td style="padding: 12px; border-bottom: 1px solid #e0e0e0;"><?= htmlspecialchars($row['course']) ?></td>
            <td style="padding: 12px; border-bottom: 1px solid #e0e0e0; font-weight: bold; color: #667eea;"><?= $row['year'] ?></td>
          </tr>
        <?php endwhile; 
    } else {
        echo "<tr><td colspan='5' style='text-align:center; color:#666; padding: 30px; font-style: italic;'>🔍 No students enrolled yet. <a href='add_student.php' style='color: #667eea; font-weight: bold;'>Register the first student</a></td></tr>";
    }
    ?>
  </table>
  
  <div style='margin-top: 20px; text-align: center; color: #666; font-size: 12px;'>
    📈 Total Records: <?= $result ? $result->num_rows : 0 ?> | Last Updated: <?= date('Y-m-d H:i:s') ?>
  </div>
</div>
</body>
</html>
