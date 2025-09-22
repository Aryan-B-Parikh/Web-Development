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
        <div class="response-container error">
            <div class="response-header">
                <div class="error-icon">✗</div>
                <h1><?php echo htmlspecialchars($title); ?></h1>
            </div>

            <div class="error-list">
                <h3>Please fix the following errors:</h3>
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <?php if (!empty($formData)): ?>
            <div class="form-data">
                <h4>Submitted Data (for debugging):</h4>
                <div class="data-display">
                    <?php foreach ($formData as $key => $value): ?>
                        <?php if ($key !== 'terms' && !empty($value)): ?>
                            <div class="data-item">
                                <strong><?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $key))); ?>:</strong>
                                <span><?php echo htmlspecialchars($value); ?></span>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <div class="technical-info">
                <h4>Error Handling Information:</h4>
                <ul>
                    <li><strong>Input Sanitization:</strong> Applied before validation</li>
                    <li><strong>Server-side Validation:</strong> Failed on <?php echo count($errors); ?> field(s)</li>
                    <li><strong>Data Security:</strong> No harmful input stored</li>
                    <li><strong>Error Logging:</strong> Errors logged for debugging</li>
                </ul>
            </div>

            <div class="actions">
                <a href="index.html" class="btn-primary">Try Again</a>
                <a href="index.html" class="btn-secondary">Start Over</a>
            </div>
        </div>

        <footer>
            <p><strong>Error Response:</strong> Demonstrating proper error handling and validation feedback</p>
        </footer>
    </div>
</body>
</html>