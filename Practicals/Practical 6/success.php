<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - Student Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="response-container success">
            <div class="response-header">
                <div class="success-icon">✓</div>
                <h1><?php echo htmlspecialchars($title); ?></h1>
            </div>

            <div class="message">
                <p><?php echo htmlspecialchars($message); ?></p>
            </div>

            <div class="student-details">
                <h3>Registration Details:</h3>
                <div class="details-grid">
                    <div class="detail-item">
                        <strong>Student ID:</strong>
                        <span><?php echo htmlspecialchars($studentData['studentid']); ?></span>
                    </div>
                    <div class="detail-item">
                        <strong>Full Name:</strong>
                        <span><?php echo htmlspecialchars($studentData['fullname']); ?></span>
                    </div>
                    <div class="detail-item">
                        <strong>Email:</strong>
                        <span><?php echo htmlspecialchars($studentData['email']); ?></span>
                    </div>
                    <div class="detail-item">
                        <strong>Phone:</strong>
                        <span><?php echo htmlspecialchars($studentData['phone']); ?></span>
                    </div>
                    <div class="detail-item">
                        <strong>Major:</strong>
                        <span><?php echo htmlspecialchars($studentData['major']); ?></span>
                    </div>
                    <div class="detail-item">
                        <strong>Academic Year:</strong>
                        <span><?php echo htmlspecialchars($studentData['year']); ?> Year</span>
                    </div>
                    <?php if (!empty($studentData['address'])): ?>
                    <div class="detail-item">
                        <strong>Address:</strong>
                        <span><?php echo htmlspecialchars($studentData['address']); ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($studentData['dob'])): ?>
                    <div class="detail-item">
                        <strong>Date of Birth:</strong>
                        <span><?php echo htmlspecialchars($studentData['dob']); ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="detail-item">
                        <strong>Registration Date:</strong>
                        <span><?php echo htmlspecialchars($studentData['registration_date']); ?></span>
                    </div>
                </div>
            </div>

            <div class="technical-info">
                <h4>Technical Information:</h4>
                <ul>
                    <li><strong>Method Used:</strong> POST (Secure data transmission)</li>
                    <li><strong>Input Sanitization:</strong> Applied (XSS protection)</li>
                    <li><strong>Data Storage:</strong> JSON file format</li>
                    <li><strong>Validation:</strong> Server-side validation completed</li>
                </ul>
            </div>

            <div class="actions">
                <a href="index.html" class="btn-primary">Register Another Student</a>
                <a href="view_registrations.php" class="btn-secondary">View All Registrations</a>
                <a href="search.php" class="btn-secondary">Search Registrations</a>
            </div>
        </div>

        <footer>
            <p><strong>Success Response:</strong> Demonstrating proper PHP form handling and data storage</p>
        </footer>
    </div>
</body>
</html>