<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// (Optional) session timeout
if (!isset($_SESSION['start_time'])) {
    $_SESSION['start_time'] = time();
} else {
    if (time() - $_SESSION['start_time'] > 300) { // 5 min timeout
        session_unset();
        session_destroy();
        header("Location: login.php?timeout=1");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Dashboard | 24CE070</title>
  <style>
    .header { background: #4CAF50; color: white; padding: 15px; margin: -20px -20px 20px -20px; }
    .student-info { font-size: 14px; margin-top: 5px; }
    .welcome-card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin: 20px 0; }
    .logout-btn { background: #f44336; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
  </style>
</head>
<body style="font-family: Arial; padding:20px; background:#f9f9f9;">
  <div class="header">
    <h2 style="margin: 0;">User Dashboard</h2>
    <div class="student-info">Student ID: 24CE070 | Practical 10: Session Management & Authentication</div>
  </div>
  
  <div class="welcome-card">
    <h3>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h3>
    <p><strong>Role:</strong> <?php echo htmlspecialchars($_SESSION['role']); ?></p>
    <p><strong>Session Started:</strong> <?php echo date('Y-m-d H:i:s', $_SESSION['start_time']); ?></p>
    <p><strong>Student ID:</strong> 24CE070</p>
    <p>This is your secure dashboard. Session will timeout after 5 minutes of inactivity.</p>
  </div>
  
  <a href="logout.php" class="logout-btn">Logout Securely</a>
</body>
</html>
