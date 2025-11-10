<?php
// login.php
require_once 'db.php';
require_once 'helpers.php';
session_start();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username_or_email = isset($_POST['identifier']) ? clean_str($_POST['identifier']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if (empty($username_or_email) || empty($password)) {
        $errors[] = 'Please fill required fields.';
    } else {
        // Fetch user safely
        $stmt = $conn->prepare('SELECT id, username, email, password_hash FROM users WHERE username = ? OR email = ? LIMIT 1');
        if ($stmt) {
            $stmt->bind_param('ss', $username_or_email, $username_or_email);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res && $user = $res->fetch_assoc()) {
                // Verify password
                if (password_verify($password, $user['password_hash'])) {
                    // Optional: rehash if algorithm changed
                    if (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT)) {
                        $newHash = password_hash($password, PASSWORD_DEFAULT);
                        $upd = $conn->prepare('UPDATE users SET password_hash = ? WHERE id = ?');
                        if ($upd) { $upd->bind_param('si', $newHash, $user['id']); $upd->execute(); $upd->close(); }
                    }

                    // Good login: store user id in session
                    session_regenerate_id(true);
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    header('Location: dashboard.php'); // change as needed
                    exit;
                } else {
                    $errors[] = 'Invalid credentials.';
                }
            } else {
                $errors[] = 'Invalid credentials.';
            }
            $stmt->close();
        } else {
            $errors[] = 'Database error (prepare).';
        }
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>User Login | 24CE070</title>
    <style>
        .header { background: #2196F3; color: white; padding: 15px; margin: -20px -20px 20px -20px; }
        .student-info { font-size: 14px; margin-top: 5px; }
        body { font-family: Arial; padding: 20px; background: #f9f9f9; }
        .form-container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        input { padding: 8px; width: 100%; margin: 5px 0 15px 0; }
        button { background: #2196F3; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; width: 100%; }
        .error { background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 15px 0; }
    </style>
</head>
<body>
<div class="header">
    <h2 style="margin: 0;">Secure Login Portal</h2>
    <div class="student-info">Student ID: 24CE070 | Practical 13: User Authentication System</div>
</div>

<div class="form-container">
    <?php if (!empty($errors)): ?>
        <div class="error">
            <strong>Login Errors:</strong>
            <ul style="margin: 10px 0 0 20px;">
            <?php foreach ($errors as $e): ?>
                <li><?php echo sanitize_output($e); ?></li>
            <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="login.php">
        <label>Username or Email:</label><br>
        <input type="text" name="identifier" required><br>
        
        <label>Password:</label><br>
        <input type="password" name="password" required><br>
        
        <button type="submit">Login to System</button>
    </form>
    
    <p style="text-align: center; margin-top: 20px;">
        Don't have an account? <a href="register.php" style="color: #2196F3;">Register Here</a>
    </p>
</div>
</body>
</html>
        