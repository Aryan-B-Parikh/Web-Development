<?php
session_start();

$data_file = 'registrations.txt';

$action = isset($_GET['action']) ? $_GET['action'] : 'form';
$message = '';
$message_type = '';

if ($_POST && isset($_POST['name'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $course = $_POST['course'];
    $year = $_POST['year'];

    if (empty($name) || empty($email) || empty($phone) || empty($course) || empty($year)) {
        $message = 'Please fill in all fields';
        $message_type = 'error';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Invalid email format';
        $message_type = 'error';
    } else {
        $student_data = array($name, $email, $phone, $course, $year, date('Y-m-d H:i:s'));
        $data_line = implode('|', $student_data) . "\n";
        
        if (file_put_contents($data_file, $data_line, FILE_APPEND)) {
            $message = "Registration successful for $name!";
            $message_type = 'success';
            $action = 'success';
        } else {
            $message = 'Failed to save registration';
            $message_type = 'error';
        }
    }
}

$search_results = [];
$search_term = '';
if ($_POST && isset($_POST['search'])) {
    $search_term = trim($_POST['search']);
    if (file_exists($data_file) && !empty($search_term)) {
        $registrations = file($data_file, FILE_IGNORE_NEW_LINES);
        foreach ($registrations as $registration) {
            $data = explode('|', $registration);
            if (count($data) >= 6) {
                if (stripos($data[0], $search_term) !== false || 
                    stripos($data[1], $search_term) !== false || 
                    stripos($data[3], $search_term) !== false) {
                    $search_results[] = $data;
                }
            }
        }
    }
    $action = 'search';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration - Practical 6</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Student Registration System</h1>
            <p>Simple PHP Form Handling</p>
        </header>

        <nav class="tab-nav">
            <a href="?action=form" class="tab <?php echo $action == 'form' ? 'active' : ''; ?>">Register</a>
            <a href="?action=view" class="tab <?php echo $action == 'view' ? 'active' : ''; ?>">View All</a>
            <a href="?action=search" class="tab <?php echo $action == 'search' ? 'active' : ''; ?>">Search</a>
        </nav>

        <?php if ($message): ?>
            <div class="message <?php echo $message_type; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <main>
            <?php if ($action == 'form' || $action == 'success'): ?>
            <section class="form-section">
                <h2>Register New Student</h2>
                <form method="POST" onsubmit="return validateForm()">
                    <div class="form-group">
                        <label for="name">Full Name:</label>
                        <input type="text" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number:</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>

                    <div class="form-group">
                        <label for="course">Course:</label>
                        <select id="course" name="course" required>
                            <option value="">Select Course</option>
                            <option value="Computer Science">Computer Science</option>
                            <option value="Business Administration">Business Administration</option>
                            <option value="Artificial Intelligence">Artificial Intelligence</option>
                            <option value="Data Science">Data Science</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="year">Academic Year:</label>
                        <select id="year" name="year" required>
                            <option value="">Select Year</option>
                            <option value="1">First Year</option>
                            <option value="2">Second Year</option>
                            <option value="3">Third Year</option>
                            <option value="4">Fourth Year</option>
                        </select>
                    </div>

                    <button type="submit" class="btn">Register Student</button>
                </form>
            </section>

            <?php elseif ($action == 'view'): ?>
            <section class="view-section">
                <h2>All Student Registrations</h2>
                
                <?php
                if (file_exists($data_file) && filesize($data_file) > 0) {
                    $registrations = file($data_file, FILE_IGNORE_NEW_LINES);
                    
                    if (!empty($registrations)) {
                        echo '<div class="registrations-list">';
                        $count = 1;
                        
                        foreach ($registrations as $registration) {
                            $data = explode('|', $registration);
                            if (count($data) >= 6) {
                                echo '<div class="registration-item">';
                                echo '<h3>Student #' . $count . '</h3>';
                                echo '<p><strong>Name:</strong> ' . htmlspecialchars($data[0]) . '</p>';
                                echo '<p><strong>Email:</strong> ' . htmlspecialchars($data[1]) . '</p>';
                                echo '<p><strong>Phone:</strong> ' . htmlspecialchars($data[2]) . '</p>';
                                echo '<p><strong>Course:</strong> ' . htmlspecialchars($data[3]) . '</p>';
                                echo '<p><strong>Year:</strong> ' . htmlspecialchars($data[4]) . '</p>';
                                echo '<p><strong>Registration Date:</strong> ' . htmlspecialchars($data[5]) . '</p>';
                                echo '</div>';
                                $count++;
                            }
                        }
                        echo '</div>';
                    } else {
                        echo '<p class="no-data">No registrations found.</p>';
                    }
                } else {
                    echo '<p class="no-data">No registrations file found.</p>';
                }
                ?>
            </section>

            <?php elseif ($action == 'search'): ?>
            <section class="search-section">
                <h2>Search Students</h2>
                <form method="POST">
                    <div class="form-group">
                        <label for="search">Search Term:</label>
                        <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($search_term); ?>" placeholder="Enter name, email, or course">
                    </div>
                    <button type="submit" class="btn">Search</button>
                </form>

                <?php if ($_POST && isset($_POST['search'])): ?>
                <div class="results-section">
                    <h3>Search Results</h3>
                    
                    <?php if (!empty($search_results)): ?>
                        <p>Found <?php echo count($search_results); ?> result(s) for "<?php echo htmlspecialchars($search_term); ?>"</p>
                        
                        <div class="search-results">
                            <?php foreach ($search_results as $index => $data): ?>
                            <div class="registration-item">
                                <h4>Result #<?php echo $index + 1; ?></h4>
                                <p><strong>Name:</strong> <?php echo htmlspecialchars($data[0]); ?></p>
                                <p><strong>Email:</strong> <?php echo htmlspecialchars($data[1]); ?></p>
                                <p><strong>Phone:</strong> <?php echo htmlspecialchars($data[2]); ?></p>
                                <p><strong>Course:</strong> <?php echo htmlspecialchars($data[3]); ?></p>
                                <p><strong>Year:</strong> <?php echo htmlspecialchars($data[4]); ?></p>
                                <p><strong>Registration Date:</strong> <?php echo htmlspecialchars($data[5]); ?></p>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="no-data">No students found matching "<?php echo htmlspecialchars($search_term); ?>"</p>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </section>
            <?php endif; ?>
        </main>
    </div>

    <script src="script.js"></script>
</body>
</html>