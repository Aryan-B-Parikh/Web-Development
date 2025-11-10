<?php
require_once 'db.php';
require_once 'helpers.php';
session_start();

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? clean_str($_POST['username']) : '';
    $email    = isset($_POST['email']) ? clean_str($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $password2 = isset($_POST['password2']) ? $_POST['password2'] : '';

    if (isset($_SESSION['captcha_sum'])) {
        if (!isset($_POST['captcha']) || (int)$_POST['captcha'] !== (int)$_SESSION['captcha_sum']) {
            $errors[] = 'Captcha answer is incorrect.';
        }
    }

    if (!is_valid_username($username)) {
        $errors[] = 'Username must be 3-30 chars: letters, numbers, underscore only.';
    }
    if (!is_valid_email($email)) {
        $errors[] = 'Invalid email format.';
    }
    if ($password !== $password2) {
        $errors[] = 'Passwords do not match.';
    }
    if (!is_strong_password($password)) {
        $errors[] = 'Password must be at least 8 chars and include uppercase, lowercase and a digit.';
    }

    if (empty($errors)) {
        $stmt = $conn->prepare('SELECT id FROM users WHERE username = ? OR email = ? LIMIT 1');
        if (!$stmt) {
            $errors[] = 'Database error (prepare).';
        } else {
            $stmt->bind_param('ss', $username, $email);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $errors[] = 'Username or email already taken.';
            }
            $stmt->close();
        }
    }

    if (empty($errors)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $insert = $conn->prepare('INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)');
        if (!$insert) {
            $errors[] = 'Database error (prepare insert).';
        } else {
            $insert->bind_param('sss', $username, $email, $hash);
            if ($insert->execute()) {
                $success = 'Registration successful. You can now log in.';
            } else {
                $errors[] = 'Failed to create user. Try again later.';
            }
            $insert->close();
        }
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>User Registration | 24CE070</title>
    <style>
        .header { background: #FF5722; color: white; padding: 15px; margin: -20px -20px 20px -20px; }
        .student-info { font-size: 14px; margin-top: 5px; }
        body { font-family: Arial; padding: 20px; background: #f9f9f9; }
        .form-container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        input { padding: 8px; width: 100%; margin: 5px 0 15px 0; }
        input[type="submit"] { background: #FF5722; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .success { background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 15px 0; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 15px 0; }
    </style>
</head>
<body>
<div class="header">
    <h2 style="margin: 0;">User Registration System</h2>
    <div class="student-info">Student ID: 24CE070 | Practical 13: Form Validation & Authentication</div>
</div>

<div class="form-container">
    <?php if ($success): ?>
        <div class="success"><strong>Success!</strong> <?php echo sanitize_output($success); ?></div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <strong>Registration Errors:</strong>
            <ul style="margin: 10px 0 0 20px;">
            <?php foreach ($errors as $e): ?>
                <li><?php echo sanitize_output($e); ?></li>
            <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

<form method="post" action="register.php" novalidate>
    Username: <input type="text" name="username" value="<?php echo isset($username) ? sanitize_output($username) : ''; ?>" required><br>
    Email: <input type="email" name="email" value="<?php echo isset($email) ? sanitize_output($email) : ''; ?>" required><br>
    Password: <input type="password" name="password" required><br>
    Confirm: <input type="password" name="password2" required><br>

    <?php
    if (empty($_SESSION['captcha_sum'])) {
        $a = rand(2,9);
        $b = rand(1,9);
        $_SESSION['captcha_q'] = "$a + $b = ?";
        $_SESSION['captcha_sum'] = $a + $b;
    }
    ?>
    <label><?php echo sanitize_output($_SESSION['captcha_q']); ?></label>
    <input type="number" name="captcha" required><br>

    <button type="submit">Register Account</button>
</form>

<p style="text-align: center; margin-top: 20px;">
    Already have an account? <a href="login.php" style="color: #FF5722;">Login Here</a>
</p>

<script>
// Enhanced form validation for Student 24CE070
function validateForm() {
    const username = document.querySelector('input[name="username"]').value.trim();
    const email = document.querySelector('input[name="email"]').value.trim();
    const pwd = document.querySelector('input[name="password"]').value;
    const pwd2 = document.querySelector('input[name="password2"]').value;

    const userRegex = /^[A-Za-z0-9_]{3,30}$/;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const pwdRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;

    if (!userRegex.test(username)) { 
        alert('Invalid username: Must be 3-30 characters, letters, numbers, underscore only'); 
        return false; 
    }
    if (!emailRegex.test(email)) { 
        alert('Invalid email format'); 
        return false; 
    }
    if (pwd !== pwd2) {
        alert('Passwords do not match');
        return false;
    }
    if (!pwdRegex.test(pwd)) { 
        alert('Weak password: Must be at least 8 characters with uppercase, lowercase and digit'); 
        return false; 
    }
    return true;
}

// Add form validation on submit
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                return false;
            }
        });
    }
});
</script>

</div>
</body>
</html>
