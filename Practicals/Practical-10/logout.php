<?php
session_start();

// Store username for goodbye message
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'User';

session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Logout | 24CE070</title>
  <style>
    .header { background: #f44336; color: white; padding: 15px; margin: -20px -20px 20px -20px; }
    .student-info { font-size: 14px; margin-top: 5px; }
    .logout-card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); text-align: center; }
  </style>
</head>
<body style="font-family: Arial; padding:20px; background:#f9f9f9;">
  <div class="header">
    <h2 style="margin: 0;">Logout Successful</h2>
    <div class="student-info">Student ID: 24CE070 | Practical 10: Session Management</div>
  </div>
  
  <div class="logout-card">
    <h3>Goodbye, <?php echo htmlspecialchars($username); ?>!</h3>
    <p>You have been successfully logged out.</p>
    <p>Your session has been terminated securely.</p>
    <a href="login.php" style="background: #2196F3; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Login Again</a>
  </div>
</body>
</html>
