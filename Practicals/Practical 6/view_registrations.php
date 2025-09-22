<?php
$registrations = [];
if (file_exists('registrations.json')) {
    $data = file_get_contents('registrations.json');
    $registrations = json_decode($data, true) ?: [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Registrations - Student Registration System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>All Student Registrations</h1>
            <p class="subtitle">Complete list of registered students</p>
        </header>

        <div class="stats">
            <div class="stat-card">
                <div class="stat-number"><?php echo count($registrations); ?></div>
                <div class="stat-label">Total Registrations</div>
            </div>
        </div>

        <div class="registrations-list">
            <?php if (empty($registrations)): ?>
                <div class="no-data">
                    <h3>No registrations found</h3>
                    <p>No student registrations have been submitted yet.</p>
                    <a href="index.html" class="btn-primary">Register First Student</a>
                </div>
            <?php else: ?>
                <div class="registrations-grid">
                    <?php foreach ($registrations as $index => $registration): ?>
                        <div class="registration-card">
                            <div class="card-header">
                                <h3><?php echo htmlspecialchars($registration['fullname']); ?></h3>
                                <span class="student-id"><?php echo htmlspecialchars($registration['studentid']); ?></span>
                            </div>
                            <div class="card-body">
                                <div class="detail-row">
                                    <strong>Email:</strong>
                                    <span><?php echo htmlspecialchars($registration['email']); ?></span>
                                </div>
                                <div class="detail-row">
                                    <strong>Phone:</strong>
                                    <span><?php echo htmlspecialchars($registration['phone']); ?></span>
                                </div>
                                <div class="detail-row">
                                    <strong>Major:</strong>
                                    <span><?php echo htmlspecialchars($registration['major']); ?></span>
                                </div>
                                <div class="detail-row">
                                    <strong>Year:</strong>
                                    <span><?php echo htmlspecialchars($registration['year']); ?> Year</span>
                                </div>
                                <?php if (!empty($registration['address'])): ?>
                                <div class="detail-row">
                                    <strong>Address:</strong>
                                    <span><?php echo htmlspecialchars($registration['address']); ?></span>
                                </div>
                                <?php endif; ?>
                                <?php if (!empty($registration['dob'])): ?>
                                <div class="detail-row">
                                    <strong>Date of Birth:</strong>
                                    <span><?php echo htmlspecialchars($registration['dob']); ?></span>
                                </div>
                                <?php endif; ?>
                                <div class="detail-row">
                                    <strong>Registered:</strong>
                                    <span><?php echo htmlspecialchars($registration['registration_date']); ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="technical-info">
            <h3>Data Retrieval Information:</h3>
            <ul>
                <li><strong>Data Source:</strong> JSON file storage</li>
                <li><strong>Method:</strong> GET request with action parameter</li>
                <li><strong>Security:</strong> Data sanitized before display</li>
                <li><strong>Format:</strong> Structured data presentation</li>
            </ul>
        </div>

        <div class="actions">
            <a href="index.html" class="btn-primary">Register New Student</a>
            <a href="search.php" class="btn-secondary">Search Registrations</a>
        </div>

        <footer>
            <p><strong>Data Display:</strong> Demonstrating PHP data retrieval and secure output</p>
        </footer>
    </div>
</body>
</html>