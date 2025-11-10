<?php
include("db.php");

// Enhanced delete operation for Student 24CE070
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize input
    $result = mysqli_query($conn, "DELETE FROM students WHERE id=$id");
    
    if ($result) {
        // Log deletion for student 24CE070
        $log_entry = "[" . date('Y-m-d H:i:s') . "] Student ID deleted: $id by 24CE070\n";
        file_put_contents("deletion_log_24ce070.txt", $log_entry, FILE_APPEND);
    }
}

header("Location: index.php?deleted=1");
exit();
?>
