const nameRegex = /^[a-zA-Z\s]+$/;
const usernameRegex = /^[a-zA-Z0-9]{5,15}$/;
const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
const phoneRegex = /^[0-9]{10}$/;

function clearError(fieldId) {
    document.getElementById(fieldId + '-error').textContent = '';
    document.getElementById(fieldId).classList.remove('error-highlight');
}

function validateField(fieldId) {
    const field = document.getElementById(fieldId);
    const value = field.value.trim();
    const errorElement = document.getElementById(fieldId + '-error');

    errorElement.textContent = '';
    field.classList.remove('error-highlight');

    let isValid = true;

    switch (fieldId) {
        case 'fullname':
            if (!nameRegex.test(value)) {
                errorElement.textContent = 'Full Name should contain only letters and spaces.';
                field.classList.add('error-highlight');
                isValid = false;
            }
            break;

        case 'studentid':
            if (!/^[a-zA-Z0-9]+$/.test(value)) {
                errorElement.textContent = 'Student ID should be alphanumeric only.';
                field.classList.add('error-highlight');
                isValid = false;
            }
            break;

        case 'email':
            if (!/^\S+@\S+\.\S+$/.test(value)) {
                errorElement.textContent = 'Please enter valid email format.';
                field.classList.add('error-highlight');
                isValid = false;
            }
            break;

        case 'username':
            if (!usernameRegex.test(value)) {
                errorElement.textContent = 'Username must be 5-15 characters and alphanumeric.';
                field.classList.add('error-highlight');
                isValid = false;
            }
            break;

        case 'password':
            if (!passwordRegex.test(value)) {
                errorElement.textContent = 'Password must be at least 8 characters with letters, digits, and one special character.';
                field.classList.add('error-highlight');
                isValid = false;
            }
            break;

        case 'confirmpassword':
            const password = document.getElementById('password').value;
            if (password !== value) {
                errorElement.textContent = 'Passwords do not match.';
                field.classList.add('error-highlight');
                isValid = false;
            }
            break;

        case 'phone':
            if (!phoneRegex.test(value)) {
                errorElement.textContent = 'Phone number must be exactly 10 digits.';
                field.classList.add('error-highlight');
                isValid = false;
            }
            break;
    }

    return isValid;
}

function validateForm() {
    const name = document.getElementById("fullname").value.trim();
    const email = document.getElementById("email").value.trim();
    const username = document.getElementById("username").value.trim();
    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("confirmpassword").value;
    const phone = document.getElementById("phone").value.trim();
    const studentId = document.getElementById("studentid").value.trim();

    const nameRegex = /^[a-zA-Z\s]+$/;
    const usernameRegex = /^[a-zA-Z0-9]{5,15}$/;
    const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
    const phoneRegex = /^[0-9]{10}$/;

    if (!nameRegex.test(name)) {
        alert("Full Name should contain only letters and spaces.");
        return false;
    }

    if (!/^[a-zA-Z0-9]+$/.test(studentId)) {
        alert("Student ID should be alphanumeric only.");
        return false;
    }

    if (!/^\S+@\S+\.\S+$/.test(email)) {
        alert("Please enter valid email format.");
        return false;
    }

    if (!usernameRegex.test(username)) {
        alert("Username must be 5-15 characters and alphanumeric.");
        return false;
    }

    if (!passwordRegex.test(password)) {
        alert("Password must be at least 8 characters with letters, digits, and one special character.");
        return false;
    }

    if (password !== confirmPassword) {
        alert("Passwords do not match.");
        return false;
    }

    if (!phoneRegex.test(phone)) {
        alert("Phone number must be exactly 10 digits.");
        return false;
    }

    const resultDiv = document.getElementById('result');
    resultDiv.innerHTML = `
        <h3>Registration Successful!</h3>
        <p><strong>Student Full Name:</strong> ${name}</p>
        <p><strong>Student ID:</strong> ${studentId}</p>
        <p><strong>Email:</strong> ${email}</p>
        <p><strong>Username:</strong> ${username}</p>
        <p><strong>Phone Number:</strong> ${phone}</p>
    `;
    resultDiv.style.display = 'block';

    alert("Registration Successful!");
    return false;
}