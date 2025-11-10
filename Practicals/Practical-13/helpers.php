<?php
// helpers.php

function clean_str($s) {
    return trim($s);
}

function sanitize_output($s) {
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function is_valid_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function is_valid_username($u) {
    // allow letters, numbers, underscore; 3-30 chars
    return preg_match('/^[A-Za-z0-9_]{3,30}$/', $u);
}

function is_strong_password($p) {
    // at least 8 chars, one uppercase, one lowercase, one digit; adjust as needed
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/', $p);
}
?>
