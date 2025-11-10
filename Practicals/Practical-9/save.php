<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $category = htmlspecialchars(trim($_POST['category'] ?? 'General'));
    $priority = htmlspecialchars(trim($_POST['priority'] ?? 'Medium'));
    $message = htmlspecialchars(trim($_POST['message']));

    // Generate unique submission ID
    $submission_id = 'FB_24CE070_' . date('Ymd') . '_' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
    $timestamp = date('Y-m-d H:i:s');
    $date_only = date('Y-m-d');
    
    // Enhanced TXT format with structured data
    $txt_entry = "=== FEEDBACK SUBMISSION ===\n";
    $txt_entry .= "Submission ID: $submission_id\n";
    $txt_entry .= "Student System: 24CE070 FeedbackHub Pro\n";
    $txt_entry .= "Date & Time: $timestamp\n";
    $txt_entry .= "Category: $category\n";
    $txt_entry .= "Priority: $priority\n";
    $txt_entry .= "Name: $name\n";
    $txt_entry .= "Email: $email\n";
    $txt_entry .= "Message: $message\n";
    $txt_entry .= "========================\n\n";
    
    file_put_contents("feedbackhub_24ce070.txt", $txt_entry, FILE_APPEND);

    // Enhanced CSV with headers and better structure
    $csv_file = "feedbackhub_24ce070.csv";
    $is_new_file = !file_exists($csv_file);
    $csv = fopen($csv_file, "a");
    
    if ($is_new_file) {
        fputcsv($csv, ['Submission_ID', 'Student_System', 'Date', 'Time', 'Category', 'Priority', 'Name', 'Email', 'Message']);
    }
    
    fputcsv($csv, [$submission_id, '24CE070_FeedbackHub', $date_only, date('H:i:s'), $category, $priority, $name, $email, $message]);
    fclose($csv);

    // Enhanced JSON with metadata
    $jsonFile = "feedbackhub_24ce070.json";
    $existingData = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];
    
    $newEntry = [
        "submission_id" => $submission_id,
        "system_info" => [
            "student_id" => "24CE070",
            "system_name" => "FeedbackHub Pro",
            "version" => "2.0"
        ],
        "timestamp" => $timestamp,
        "feedback_data" => [
            "category" => $category,
            "priority" => $priority,
            "name" => $name,
            "email" => $email,
            "message" => $message
        ],
        "metadata" => [
            "ip_address" => $_SERVER['REMOTE_ADDR'] ?? 'Unknown',
            "user_agent" => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
            "processing_time" => microtime(true)
        ]
    ];
    
    $existingData[] = $newEntry;
    file_put_contents($jsonFile, json_encode($existingData, JSON_PRETTY_PRINT));

    // Create daily summary
    $summary_file = "daily_summary_24ce070_" . $date_only . ".log";
    $summary_entry = "[$timestamp] NEW FEEDBACK: $submission_id | $category | $priority | $name\n";
    file_put_contents($summary_file, $summary_entry, FILE_APPEND);

    // Display success page with enhanced styling
    echo "<!DOCTYPE html>";
    echo "<html><head><title>Feedback Submitted Successfully | 24CE070</title>";
    echo "<style>";
    echo "body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(120deg, #a8edea 0%, #fed6e3 100%); margin: 0; padding: 20px; }";
    echo ".success-container { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); max-width: 600px; margin: 50px auto; text-align: center; }";
    echo ".header { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white; padding: 20px; margin: -40px -40px 30px -40px; border-radius: 20px 20px 0 0; }";
    echo ".info-card { background: #f0f8ff; padding: 20px; border-radius: 15px; margin: 20px 0; border-left: 5px solid #667eea; }";
    echo ".btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; font-weight: bold; display: inline-block; margin-top: 20px; transition: transform 0.2s; }";
    echo ".btn:hover { transform: translateY(-2px); }";
    echo "</style></head><body>";
    
    echo "<div class='success-container'>";
    echo "<div class='header'>";
    echo "<h2 style='margin: 0; font-size: 28px;'>🎉 Feedback Submitted Successfully!</h2>";
    echo "<p style='margin: 10px 0 0 0; opacity: 0.9;'>FeedbackHub Pro - Student 24CE070</p>";
    echo "</div>";
    
    echo "<div class='info-card'>";
    echo "<h3 style='color: #667eea; margin-top: 0;'>📋 Submission Details</h3>";
    echo "<p><strong>Submission ID:</strong> $submission_id</p>";
    echo "<p><strong>Name:</strong> $name</p>";
    echo "<p><strong>Category:</strong> $category</p>";
    echo "<p><strong>Priority:</strong> $priority</p>";
    echo "<p><strong>Processed:</strong> $timestamp</p>";
    echo "</div>";
    
    echo "<div style='background: #e8f5e8; padding: 15px; border-radius: 10px; margin: 20px 0;'>";
    echo "<p><strong>✅ Data Storage Status:</strong></p>";
    echo "<p>📄 TXT Format: Saved to feedbackhub_24ce070.txt</p>";
    echo "<p>📊 CSV Format: Saved to feedbackhub_24ce070.csv</p>";
    echo "<p>📋 JSON Format: Saved to feedbackhub_24ce070.json</p>";
    echo "<p>📈 Daily Summary: Updated in daily logs</p>";
    echo "</div>";
    
    echo "<a href='form.html' class='btn'>🔄 Submit Another Feedback</a>";
    echo "</div></body></html>";
    
} else {
    // Error page with enhanced styling
    echo "<!DOCTYPE html>";
    echo "<html><head><title>Error | 24CE070</title>";
    echo "<style>";
    echo "body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(120deg, #ff9a9e 0%, #fecfef 100%); margin: 0; padding: 20px; }";
    echo ".error-container { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); max-width: 500px; margin: 100px auto; text-align: center; }";
    echo ".btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 30px; text-decoration: none; border-radius: 25px; font-weight: bold; }";
    echo "</style></head><body>";
    echo "<div class='error-container'>";
    echo "<h2 style='color: #e74c3c;'>⚠️ Invalid Request</h2>";
    echo "<p>Please submit the form properly through the FeedbackHub Pro interface.</p>";
    echo "<p><strong>System:</strong> 24CE070 FeedbackHub Pro</p>";
    echo "<a href='form.html' class='btn'>🔄 Return to Form</a>";
    echo "</div></body></html>";
}
?>
