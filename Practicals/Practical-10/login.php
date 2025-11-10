<?php
session_start();

// Advanced user management system for Student 24CE070
$users = [
    ["username" => "admin_24ce070", "password" => "SecurePass@2024", "role" => "administrator", "full_name" => "System Administrator"],
    ["username" => "student_24ce070", "password" => "MyPass@123", "role" => "student", "full_name" => "Primary Student"],
    ["username" => "instructor_24ce070", "password" => "Teach@2024", "role" => "instructor", "full_name" => "Course Instructor"],
    ["username" => "guest_24ce070", "password" => "Guest@123", "role" => "guest", "full_name" => "Guest User"]
];

// If already logged in
if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}

// Enhanced login processing with security features
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uname = trim($_POST['username']);
    $pwd   = trim($_POST['password']);
    
    // Rate limiting check (simplified)
    if (!isset($_SESSION['login_attempts'])) {
        $_SESSION['login_attempts'] = 0;
        $_SESSION['last_attempt'] = time();
    }
    
    if ($_SESSION['login_attempts'] >= 3 && (time() - $_SESSION['last_attempt']) < 300) {
        $error = "Too many failed attempts. Please wait 5 minutes.";
    } else {
        $valid = false;
        foreach ($users as $user) {
            if ($uname === $user['username'] && $pwd === $user['password']) {
                $_SESSION['username'] = $uname;
                $_SESSION['role'] = $user['role'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['login_time'] = date('Y-m-d H:i:s');
                $_SESSION['session_id'] = 'SESS_24CE070_' . uniqid();
                
                // Reset login attempts
                $_SESSION['login_attempts'] = 0;
                $valid = true;
                break;
            }
        }

        if ($valid) {
            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION['login_attempts']++;
            $_SESSION['last_attempt'] = time();
            $error = "Invalid credentials. Attempt " . $_SESSION['login_attempts'] . "/3";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>SecureAuth Portal | 24CE070</title>
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      margin: 0;
      padding: 0;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .login-container {
      background: rgba(255, 255, 255, 0.95);
      padding: 40px;
      border-radius: 20px;
      box-shadow: 0 15px 35px rgba(0,0,0,0.1);
      backdrop-filter: blur(10px);
      max-width: 450px;
      width: 100%;
    }
    .header {
      text-align: center;
      margin-bottom: 30px;
    }
    .logo {
      font-size: 48px;
      margin-bottom: 10px;
    }
    .title {
      color: #667eea;
      font-size: 28px;
      font-weight: bold;
      margin: 0;
    }
    .subtitle {
      color: #666;
      font-size: 14px;
      margin-top: 5px;
    }
    .form-group {
      margin-bottom: 20px;
    }
    label {
      display: block;
      margin-bottom: 8px;
      font-weight: 600;
      color: #555;
    }
    input {
      width: 100%;
      padding: 15px;
      border: 2px solid #e1e5e9;
      border-radius: 10px;
      font-size: 16px;
      transition: all 0.3s ease;
    }
    input:focus {
      border-color: #667eea;
      outline: none;
      box-shadow: 0 0 10px rgba(102, 126, 234, 0.2);
    }
    .login-btn {
      width: 100%;
      padding: 15px;
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: transform 0.2s;
      margin-top: 10px;
    }
    .login-btn:hover {
      transform: translateY(-2px);
    }
    .error {
      background: #ffebee;
      color: #c62828;
      padding: 15px;
      border-radius: 10px;
      margin-bottom: 20px;
      border-left: 4px solid #f44336;
    }
    .demo-accounts {
      background: #f3f4f6;
      padding: 20px;
      border-radius: 10px;
      margin-top: 25px;
    }
    .demo-accounts h4 {
      margin-top: 0;
      color: #667eea;
    }
    .account-info {
      background: white;
      padding: 10px;
      border-radius: 5px;
      margin: 5px 0;
      font-size: 12px;
      display: flex;
      justify-content: space-between;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <div class="header">
      <div class="logo">🔐</div>
      <h1 class="title">SecureAuth Portal</h1>
      <p class="subtitle">Advanced Authentication System | Student 24CE070</p>
    </div>
    
    <?php if (isset($error)): ?>
      <div class="error">
        <strong>⚠️ Authentication Failed:</strong><br>
        <?php echo htmlspecialchars($error); ?>
      </div>
    <?php endif; ?>
    
    <form method="POST" action="">
      <div class="form-group">
        <label for="username">👤 Username:</label>
        <input type="text" id="username" name="username" required placeholder="Enter your username">
      </div>
      
      <div class="form-group">
        <label for="password">🔑 Password:</label>
        <input type="password" id="password" name="password" required placeholder="Enter your password">
      </div>
      
      <button type="submit" class="login-btn">🚀 Sign In Securely</button>
    </form>
    
    <div class="demo-accounts">
      <h4>🧪 Test Accounts (24CE070):</h4>
      <div class="account-info">
        <span><strong>Administrator:</strong> admin_24ce070</span>
        <span>SecurePass@2024</span>
      </div>
      <div class="account-info">
        <span><strong>Student:</strong> student_24ce070</span>
        <span>MyPass@123</span>
      </div>
      <div class="account-info">
        <span><strong>Instructor:</strong> instructor_24ce070</span>
        <span>Teach@2024</span>
      </div>
      <div class="account-info">
        <span><strong>Guest:</strong> guest_24ce070</span>
        <span>Guest@123</span>
      </div>
    </div>
  </div>
</body>
</html>
