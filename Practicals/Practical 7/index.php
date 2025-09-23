<?php
session_start();

$users = array(
    'admin' => 'password',
    'student' => 'student123'
);

$action = isset($_GET['action']) ? $_GET['action'] : 'login';
$message = '';
$message_type = '';

if ($action == 'logout') {
    session_destroy();
    if (isset($_COOKIE['remember_user'])) {
        setcookie('remember_user', '', time() - 3600);
    }
    header("Location: ?action=login&message=You have been logged out successfully");
    exit();
}

if ($_POST && isset($_POST['username'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);
    
    if (empty($username) || empty($password)) {
        $message = 'Please fill in all fields';
        $message_type = 'error';
    } elseif (isset($users[$username]) && $users[$username] === $password) {
        $_SESSION['username'] = $username;
        $_SESSION['login_time'] = date('Y-m-d H:i:s');
        
        if ($remember) {
            setcookie('remember_user', $username, time() + (30 * 24 * 60 * 60));
        }
        
        $action = 'dashboard';
    } else {
        $message = 'Invalid username or password';
        $message_type = 'error';
    }
}

if ($action == 'refresh' && isset($_SESSION['username'])) {
    $_SESSION['login_time'] = date('Y-m-d H:i:s');
    $message = 'Session refreshed successfully';
    $message_type = 'success';
    $action = 'dashboard';
}

if ($action == 'dashboard' && !isset($_SESSION['username'])) {
    $action = 'login';
    $message = 'Please log in first';
    $message_type = 'error';
}

if (isset($_GET['message'])) {
    $message = $_GET['message'];
    $message_type = 'success';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Login System - Practical 7</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Simple Login System</h1>
            <p>Basic Session & Cookie Management</p>
        </header>

        <?php if ($message): ?>
            <div class="message <?php echo $message_type; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <main>
            <?php if ($action == 'login'): ?>
            
            <section class="login-section">
                <h2>Login</h2>
                <form method="POST" onsubmit="return validateLogin()">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" value="<?php echo isset($_COOKIE['remember_user']) ? htmlspecialchars($_COOKIE['remember_user']) : ''; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="remember" id="remember" <?php echo isset($_COOKIE['remember_user']) ? 'checked' : ''; ?>>
                            Remember me
                        </label>
                    </div>

                    <button type="submit" class="btn">Login</button>
                </form>

                <div class="demo-info">
                    <h3>Demo Credentials:</h3>
                    <p><strong>Username:</strong> admin | <strong>Password:</strong> password</p>
                    <p><strong>Username:</strong> student | <strong>Password:</strong> student123</p>
                </div>
            </section>

            <?php elseif ($action == 'dashboard'): ?>
            
            <section class="dashboard-section">
                <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
                
                <div class="info-card">
                    <h3>Session Information</h3>
                    <p><strong>Username:</strong> <?php echo htmlspecialchars($_SESSION['username']); ?></p>
                    <p><strong>Login Time:</strong> <?php echo htmlspecialchars($_SESSION['login_time']); ?></p>
                    <p><strong>Session ID:</strong> <?php echo session_id(); ?></p>
                </div>

                <div class="info-card">
                    <h3>Cookie Information</h3>
                    <?php if (isset($_COOKIE['remember_user'])): ?>
                        <p><strong>Remember Cookie:</strong> Set for user "<?php echo htmlspecialchars($_COOKIE['remember_user']); ?>"</p>
                    <?php else: ?>
                        <p><strong>Remember Cookie:</strong> Not set</p>
                    <?php endif; ?>
                </div>

                <div class="actions">
                    <a href="?action=refresh" class="btn btn-secondary">Refresh Session</a>
                    <a href="?action=logout" class="btn btn-danger">Logout</a>
                </div>
            </section>
            <?php endif; ?>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>