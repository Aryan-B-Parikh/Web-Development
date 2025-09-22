<?php
$searchResults = [];
$searchQuery = '';
$searchField = 'fullname';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['query'])) {
    $searchQuery = htmlspecialchars(trim($_GET['query']), ENT_QUOTES, 'UTF-8');
    $searchField = htmlspecialchars($_GET['field'] ?? 'fullname', ENT_QUOTES, 'UTF-8');
    
    if (file_exists('registrations.json')) {
        $data = file_get_contents('registrations.json');
        $registrations = json_decode($data, true) ?: [];
        
        foreach ($registrations as $registration) {
            if (isset($registration[$searchField]) && 
                stripos($registration[$searchField], $searchQuery) !== false) {
                $searchResults[] = $registration;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Registrations - Student Registration System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Search Student Registrations</h1>
            <p class="subtitle">Find specific student records using GET method</p>
        </header>

        <div class="search-form-container">
            <form method="GET" action="search.php" class="search-form">
                <div class="search-group">
                    <label for="query">Search Query:</label>
                    <input type="text" id="query" name="query" 
                           value="<?php echo htmlspecialchars($searchQuery); ?>" 
                           placeholder="Enter search term..." required>
                </div>
                
                <div class="search-group">
                    <label for="field">Search Field:</label>
                    <select id="field" name="field">
                        <option value="fullname" <?php echo $searchField === 'fullname' ? 'selected' : ''; ?>>Full Name</option>
                        <option value="studentid" <?php echo $searchField === 'studentid' ? 'selected' : ''; ?>>Student ID</option>
                        <option value="email" <?php echo $searchField === 'email' ? 'selected' : ''; ?>>Email</option>
                        <option value="major" <?php echo $searchField === 'major' ? 'selected' : ''; ?>>Major</option>
                        <option value="year" <?php echo $searchField === 'year' ? 'selected' : ''; ?>>Year</option>
                    </select>
                </div>
                
                <button type="submit" class="btn-search">Search</button>
                <a href="search.php" class="btn-clear">Clear</a>
            </form>
        </div>

        <?php if (!empty($searchQuery)): ?>
            <div class="search-results">
                <h3>Search Results for "<?php echo htmlspecialchars($searchQuery); ?>" in <?php echo htmlspecialchars(ucfirst($searchField)); ?></h3>
                
                <?php if (empty($searchResults)): ?>
                    <div class="no-results">
                        <p>No registrations found matching your search criteria.</p>
                    </div>
                <?php else: ?>
                    <div class="results-count">
                        <p>Found <?php echo count($searchResults); ?> registration(s)</p>
                    </div>
                    
                    <div class="registrations-grid">
                        <?php foreach ($searchResults as $registration): ?>
                            <div class="registration-card highlighted">
                                <div class="card-header">
                                    <h4><?php echo htmlspecialchars($registration['fullname']); ?></h4>
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
        <?php endif; ?>

        <div class="technical-info">
            <h3>Search Implementation:</h3>
            <ul>
                <li><strong>Method:</strong> GET request for search queries</li>
                <li><strong>Input Sanitization:</strong> Search terms sanitized</li>
                <li><strong>Search Algorithm:</strong> Case-insensitive string matching</li>
                <li><strong>Data Security:</strong> Output escaped for XSS protection</li>
            </ul>
        </div>

        <div class="actions">
            <a href="index.html" class="btn-primary">Register New Student</a>
            <a href="view_registrations.php" class="btn-secondary">View All Registrations</a>
        </div>

        <footer>
            <p><strong>Search Functionality:</strong> Demonstrating GET method usage and data filtering</p>
        </footer>
    </div>
</body>
</html>