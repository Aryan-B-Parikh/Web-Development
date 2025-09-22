<?php
session_start();

class RegistrationHandler {
    private $dataFile = 'registrations.json';
    private $errors = [];
    private $data = [];

    public function __construct() {
        $this->ensureDataFileExists();
    }

    private function ensureDataFileExists() {
        if (!file_exists($this->dataFile)) {
            file_put_contents($this->dataFile, json_encode([]));
        }
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->processRegistration();
        } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
            return $this->handleGetRequest();
        } else {
            return $this->redirectToForm();
        }
    }

    private function processRegistration() {
        $this->data = $this->sanitizeInput($_POST);
        
        if ($this->validateInput()) {
            if ($this->saveRegistration()) {
                return $this->showSuccess();
            } else {
                $this->errors[] = "Failed to save registration data.";
                return $this->showError();
            }
        } else {
            return $this->showError();
        }
    }

    private function sanitizeInput($input) {
        $sanitized = [];
        
        foreach ($input as $key => $value) {
            if (is_string($value)) {
                $sanitized[$key] = htmlspecialchars(strip_tags(trim($value)), ENT_QUOTES, 'UTF-8');
            } else {
                $sanitized[$key] = $value;
            }
        }

        $sanitized['fullname'] = filter_var($sanitized['fullname'] ?? '', FILTER_SANITIZE_STRING);
        $sanitized['studentid'] = preg_replace('/[^a-zA-Z0-9]/', '', $sanitized['studentid'] ?? '');
        $sanitized['email'] = filter_var($sanitized['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $sanitized['phone'] = preg_replace('/[^0-9+\-\s]/', '', $sanitized['phone'] ?? '');
        $sanitized['major'] = filter_var($sanitized['major'] ?? '', FILTER_SANITIZE_STRING);
        $sanitized['year'] = filter_var($sanitized['year'] ?? '', FILTER_SANITIZE_NUMBER_INT);
        $sanitized['address'] = filter_var($sanitized['address'] ?? '', FILTER_SANITIZE_STRING);
        $sanitized['dob'] = filter_var($sanitized['dob'] ?? '', FILTER_SANITIZE_STRING);

        return $sanitized;
    }

    private function validateInput() {
        $isValid = true;

        if (empty($this->data['fullname']) || strlen($this->data['fullname']) < 2) {
            $this->errors[] = "Full name must be at least 2 characters long.";
            $isValid = false;
        }

        if (empty($this->data['studentid']) || !preg_match('/^[a-zA-Z0-9]{4,20}$/', $this->data['studentid'])) {
            $this->errors[] = "Student ID must be 4-20 alphanumeric characters.";
            $isValid = false;
        }

        if (empty($this->data['email']) || !filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "Please provide a valid email address.";
            $isValid = false;
        }

        if (empty($this->data['phone']) || !preg_match('/^[0-9+\-\s]{10,15}$/', $this->data['phone'])) {
            $this->errors[] = "Please provide a valid phone number (10-15 digits).";
            $isValid = false;
        }

        if (empty($this->data['major'])) {
            $this->errors[] = "Please select a major/course.";
            $isValid = false;
        }

        if (empty($this->data['year']) || !in_array($this->data['year'], ['1', '2', '3', '4'])) {
            $this->errors[] = "Please select a valid academic year.";
            $isValid = false;
        }

        if (!isset($this->data['terms'])) {
            $this->errors[] = "You must agree to the terms and conditions.";
            $isValid = false;
        }

        if ($this->isStudentIdExists($this->data['studentid'])) {
            $this->errors[] = "Student ID already exists. Please use a different Student ID.";
            $isValid = false;
        }

        if ($this->isEmailExists($this->data['email'])) {
            $this->errors[] = "Email address already registered. Please use a different email.";
            $isValid = false;
        }

        return $isValid;
    }

    private function isStudentIdExists($studentId) {
        $registrations = $this->loadRegistrations();
        foreach ($registrations as $registration) {
            if ($registration['studentid'] === $studentId) {
                return true;
            }
        }
        return false;
    }

    private function isEmailExists($email) {
        $registrations = $this->loadRegistrations();
        foreach ($registrations as $registration) {
            if ($registration['email'] === $email) {
                return true;
            }
        }
        return false;
    }

    private function saveRegistration() {
        try {
            $registrations = $this->loadRegistrations();
            
            $this->data['id'] = uniqid('reg_', true);
            $this->data['registration_date'] = date('Y-m-d H:i:s');
            $this->data['ip_address'] = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
            
            $registrations[] = $this->data;
            
            $jsonData = json_encode($registrations, JSON_PRETTY_PRINT);
            
            if ($jsonData === false) {
                return false;
            }
            
            return file_put_contents($this->dataFile, $jsonData) !== false;
        } catch (Exception $e) {
            error_log("Registration save error: " . $e->getMessage());
            return false;
        }
    }

    private function loadRegistrations() {
        if (!file_exists($this->dataFile)) {
            return [];
        }
        
        $data = file_get_contents($this->dataFile);
        $registrations = json_decode($data, true);
        
        return is_array($registrations) ? $registrations : [];
    }

    private function handleGetRequest() {
        switch ($_GET['action']) {
            case 'view':
                return $this->viewRegistrations();
            case 'search':
                return $this->searchRegistrations();
            default:
                return $this->redirectToForm();
        }
    }

    private function viewRegistrations() {
        $registrations = $this->loadRegistrations();
        include 'view_registrations.php';
        exit;
    }

    private function searchRegistrations() {
        include 'search.php';
        exit;
    }

    private function showSuccess() {
        $title = "Registration Successful";
        $message = "Student registration has been completed successfully!";
        $studentData = $this->data;
        include 'success.php';
        exit;
    }

    private function showError() {
        $title = "Registration Failed";
        $errors = $this->errors;
        $formData = $this->data;
        include 'error.php';
        exit;
    }

    private function redirectToForm() {
        header('Location: index.html');
        exit;
    }
}

try {
    $handler = new RegistrationHandler();
    $handler->handleRequest();
} catch (Exception $e) {
    error_log("Registration handler error: " . $e->getMessage());
    
    $title = "System Error";
    $errors = ["A system error occurred. Please try again later."];
    $formData = [];
    include 'error.php';
}
?>