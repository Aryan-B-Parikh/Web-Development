<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>EventMaster Pro | 24CE070</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }
        .header {
            background: rgba(255, 255, 255, 0.95);
            color: #667eea;
            padding: 25px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            text-align: center;
            margin-bottom: 30px;
            backdrop-filter: blur(10px);
        }
        .student-info {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            display: inline-block;
            font-size: 14px;
            margin-top: 10px;
        }
        .controls {
            text-align: center;
            margin-bottom: 30px;
        }
        .add-btn {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            font-size: 16px;
            transition: transform 0.2s;
            display: inline-block;
        }
        .add-btn:hover {
            transform: translateY(-3px);
        }
        .events-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
        }
        .events-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .event-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.2s;
            border-left: 5px solid #667eea;
        }
        .event-card:hover {
            transform: translateY(-5px);
        }
        .event-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .event-title {
            font-size: 18px;
            font-weight: bold;
            color: #667eea;
            margin: 0;
        }
        .event-status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-open {
            background: #e8f5e8;
            color: #2e7d32;
        }
        .status-closed {
            background: #ffebee;
            color: #c62828;
        }
        .event-details {
            margin: 10px 0;
            color: #666;
        }
        .event-poster {
            text-align: center;
            margin: 15px 0;
        }
        .event-actions {
            margin-top: 15px;
            text-align: center;
        }
        .action-btn {
            padding: 8px 15px;
            border: none;
            border-radius: 20px;
            margin: 0 5px;
            cursor: pointer;
            font-size: 12px;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
        }
        .edit-btn {
            background: #fff3e0;
            color: #f57c00;
        }
        .delete-btn {
            background: #ffebee;
            color: #d32f2f;
        }
        .no-events {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="margin: 0; font-size: 32px;">🎉 EventMaster Pro</h1>
        <div class="student-info">👨‍💻 Advanced Event Management | Student 24CE070</div>
    </div>
    
    <div class="controls">
        <a href="add_event.php" class="add-btn">✨ Create New Event</a>
    </div>
    <div class="events-container">
        <h3 style="color: #667eea; margin-top: 0; text-align: center;">📅 Event Calendar</h3>
        
        <?php
        $result = $conn->query("SELECT * FROM events ORDER BY date DESC");
        if ($result && $result->num_rows > 0) {
            echo "<div class='events-grid'>";
            while($row = $result->fetch_assoc()) {
                $poster_display = "";
                if ($row['poster']) {
                    $poster_path = "upload_24ce070/" . $row['poster'];
                    if (file_exists($poster_path)) {
                        $poster_display = "<img src='$poster_path' style='max-width: 100%; max-height: 150px; border-radius: 10px;' alt='Event Poster'>";
                    } else {
                        $original_path = "upload/" . $row['poster'];
                        if (file_exists($original_path)) {
                            $poster_display = "<img src='$original_path' style='max-width: 100%; max-height: 150px; border-radius: 10px;' alt='Event Poster'>";
                        }
                    }
                }
                
                $status_class = $row['status'] === 'open' ? 'status-open' : 'status-closed';
                $event_icon = $row['status'] === 'open' ? '🔄' : '🔒';
                
                echo "<div class='event-card'>";
                echo "<div class='event-header'>";
                echo "<h3 class='event-title'>🎆 " . htmlspecialchars($row['title']) . "</h3>";
                echo "<span class='event-status $status_class'>$event_icon " . ucfirst($row['status']) . "</span>";
                echo "</div>";
                
                echo "<div class='event-details'>";
                echo "<p><strong>📅 Date:</strong> " . date('F j, Y', strtotime($row['date'])) . "</p>";
                echo "<p><strong>📍 Location:</strong> " . htmlspecialchars($row['location']) . "</p>";
                echo "<p><strong>🆔 Event ID:</strong> #" . $row['event_id'] . "</p>";
                echo "</div>";
                
                if ($poster_display) {
                    echo "<div class='event-poster'>$poster_display</div>";
                }
                
                echo "<div class='event-actions'>";
                echo "<a href='edit_event.php?id={$row['event_id']}' class='action-btn edit-btn'>✏️ Edit</a>";
                echo "<a href='delete_event.php?id={$row['event_id']}' class='action-btn delete-btn' onclick='return confirm(\"Are you sure you want to delete this event?\");'>🗑️ Delete</a>";
                echo "</div>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<div class='no-events'>";
            echo "<h3>🔍 No Events Found</h3>";
            echo "<p>No events have been created yet. Start by adding your first event!</p>";
            echo "<a href='add_event.php' class='add-btn'>🎉 Create First Event</a>";
            echo "</div>";
        }
        ?>
        
        <div style='margin-top: 30px; text-align: center; color: #666; font-size: 12px; padding: 20px; background: #f8f9fa; border-radius: 10px;'>
            📈 Total Events: <?= $result ? $result->num_rows : 0 ?> | System: EventMaster Pro 24CE070 | Last Updated: <?= date('Y-m-d H:i:s') ?>
        </div>
    </div>
</body>
</html>
