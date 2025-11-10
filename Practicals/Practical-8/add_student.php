<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($conn) {
        $id = intval($_POST['student_id']);
        $name = $conn->real_escape_string($_POST['name']);
        $email = $conn->real_escape_string($_POST['email']);
        $course = $conn->real_escape_string($_POST['course']);
        $year = intval($_POST['year']);

        $sql = "INSERT INTO students (student_id, name, email, course, year)
                VALUES ($id, '$name', '$email', '$course', $year)";

        if ($conn->query($sql) === TRUE) {
            echo "<p style='color:green;'>Student Added Successfully!</p>";
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
  <title>Student Registration Portal | 24CE070</title>
  <style>
    .header { 
      background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); 
      color: white; 
      padding: 20px; 
      margin: -20px -20px 25px -20px; 
      border-radius: 0 0 20px 20px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .student-info { 
      font-size: 13px; 
      margin-top: 8px; 
      background: rgba(255,255,255,0.15);
      padding: 5px 12px;
      border-radius: 25px;
      display: inline-block;
    }
    .form-container {
      background: white;
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.1);
      max-width: 600px;
      margin: 0 auto;
    }
    .form-group {
      margin-bottom: 20px;
    }
    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
      color: #11998e;
    }
    input, select {
      width: 100%;
      padding: 12px;
      border: 2px solid #e0e0e0;
      border-radius: 10px;
      font-size: 16px;
      transition: border-color 0.3s;
    }
    input:focus, select:focus {
      border-color: #11998e;
      outline: none;
      box-shadow: 0 0 5px rgba(17, 153, 142, 0.3);
    }
    .submit-btn {
      background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
      color: white;
      padding: 15px 30px;
      border: none;
      border-radius: 25px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: transform 0.2s;
      width: 100%;
    }
    .submit-btn:hover {
      transform: translateY(-2px);
    }
  </style>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding:20px; background: linear-gradient(120deg, #84fab0 0%, #8fd3f4 100%); min-height: 100vh;">
  <div class="header">
    <h2 style="margin: 0; font-size: 28px;">🎓 Student Registration Portal</h2>
    <div class="student-info">👨‍💻 Created by: 24CE070 | Advanced Student Management System</div>
  </div>
  <div class="form-container">
    <h3 style="color: #11998e; margin-top: 0; text-align: center;">📝 Register New Student</h3>
    
    <form method="POST" action="" onsubmit="return validateForm()">
      <div class="form-group">
        <label for="student_id">🆔 Student ID Number:</label>
        <input type="number" id="student_id" name="student_id" required min="1" placeholder="Enter unique student ID">
      </div>
      
      <div class="form-group">
        <label for="name">👤 Full Name:</label>
        <input type="text" id="name" name="name" required placeholder="Enter student's full name" pattern="[A-Za-z\s]+">
      </div>
      
      <div class="form-group">
        <label for="email">📧 Email Address:</label>
        <input type="email" id="email" name="email" required placeholder="student@example.com">
      </div>
      
      <div class="form-group">
        <label for="course">📚 Course Program:</label>
        <select id="course" name="course" required>
          <option value="">Select Course Program</option>
          <option value="Computer Engineering">Computer Engineering</option>
          <option value="Information Technology">Information Technology</option>
          <option value="Electronics Engineering">Electronics Engineering</option>
          <option value="Mechanical Engineering">Mechanical Engineering</option>
          <option value="Civil Engineering">Civil Engineering</option>
          <option value="Electrical Engineering">Electrical Engineering</option>
        </select>
      </div>
      
      <div class="form-group">
        <label for="year">📅 Academic Year:</label>
        <select id="year" name="year" required>
          <option value="">Select Academic Year</option>
          <option value="1">First Year</option>
          <option value="2">Second Year</option>
          <option value="3">Third Year</option>
          <option value="4">Fourth Year</option>
        </select>
      </div>
      
      <button type="submit" class="submit-btn">✅ Register Student</button>
    </form>
    
    <div style="text-align: center; margin-top: 20px;">
      <a href="index.php" style="color: #11998e; text-decoration: none; font-weight: bold;">← Back to Student Directory</a>
    </div>
  </div>
  
  <script>
  function validateForm() {
    var studentId = document.getElementById('student_id').value;
    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;
    
    if (studentId.length < 4) {
      alert('Student ID must be at least 4 digits long!');
      return false;
    }
    
    if (name.length < 2) {
      alert('Please enter a valid full name!');
      return false;
    }
    
    if (!email.includes('@') || !email.includes('.')) {
      alert('Please enter a valid email address!');
      return false;
    }
    
    return true;
  }
  </script>
</body>
</html>
