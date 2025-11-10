// Validation patterns
const patterns = {
    candidateName: /^[A-Za-z][A-Za-z\s]{2,}$/,
    username: /^[a-zA-Z][a-zA-Z0-9_]{4,19}$/,
    password: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/,
    email: /^[\w.%+-]+@[\w.-]+\.[A-Za-z]{2,}$/,
    phone: /^(\+91[-\s]?)?[6-9]\d{9}$/,
    pincode: /^\d{6}$/,
    city: /^[A-Za-z][A-Za-z\s]{2,}$/,
    state: /^[A-Za-z][A-Za-z\s]{2,}$/,
    resumeUrl: /^https?:\/\/.*\.(pdf|doc|docx)$/i
};

// City-State mapping
const pincodeData = {
    '110001': {city: 'New Delhi', state: 'Delhi'},
    '400001': {city: 'Mumbai', state: 'Maharashtra'},
    '560001': {city: 'Bangalore', state: 'Karnataka'},
    '600001': {city: 'Chennai', state: 'Tamil Nadu'},
    '700001': {city: 'Kolkata', state: 'West Bengal'},
    '380001': {city: 'Ahmedabad', state: 'Gujarat'}
};

// Show error
function showError(field, message) {
    const input = document.getElementById(field);
    const error = document.getElementById(field + 'Error');
    input.classList.add('invalid');
    input.classList.remove('valid');
    error.textContent = message;
    error.style.display = 'block';
}

// Show success
function showSuccess(field) {
    const input = document.getElementById(field);
    const error = document.getElementById(field + 'Error');
    input.classList.remove('invalid');
    input.classList.add('valid');
    error.style.display = 'none';
}

// Validate field
function validate(field, value) {
    if (!value.trim()) {
        showError(field, 'Required');
        return false;
    }
    if (patterns[field] && !patterns[field].test(value)) {
        const messages = {
            candidateName: 'Name: 3+ chars, start with letter',
            username: 'Username: 5-20 chars, alphanumeric + underscore',
            password: '8+ chars, upper, lower, number, special char',
            email: 'Valid email required',
            phone: 'Valid Indian phone required',
            pincode: '6-digit pincode required',
            resumeUrl: 'Valid PDF/DOC URL required'
        };
        showError(field, messages[field]);
        return false;
    }
    showSuccess(field);
    return true;
}

// Check username availability
async function checkUsername(username) {
    if (!validate('username', username)) return;
    const status = document.getElementById('usernameStatus');
    status.textContent = 'Checking...';
    status.className = 'status-message checking';
    
    setTimeout(() => {
        const taken = ['admin', 'user', 'test', 'demo'];
        if (taken.includes(username.toLowerCase())) {
            showError('username', 'Username not available');
            status.textContent = 'Not available';
            status.className = 'status-message unavailable';
        } else {
            status.textContent = 'Available';
            status.className = 'status-message available';
        }
    }, 1000);
}

// Check email availability
async function checkEmail(email) {
    if (!validate('email', email)) return;
    const status = document.getElementById('emailStatus');
    status.textContent = 'Checking...';
    status.className = 'status-message checking';
    
    setTimeout(() => {
        const existing = ['test@example.com', 'admin@company.com'];
        if (existing.includes(email.toLowerCase())) {
            showError('email', 'Email already registered');
            status.textContent = 'Already exists';
            status.className = 'status-message unavailable';
        } else {
            status.textContent = 'Available';
            status.className = 'status-message available';
        }
    }, 800);
}

// Password strength
function checkPasswordStrength(password) {
    const strength = document.getElementById('passwordStrength');
    const score = getPasswordScore(password);
    const levels = ['weak', 'medium', 'strong', 'very-strong'];
    strength.className = 'strength-indicator ' + levels[score];
}

function getPasswordScore(password) {
    let score = 0;
    if (password.length >= 8) score++;
    if (/[a-z]/.test(password)) score++;
    if (/[A-Z]/.test(password)) score++;
    if (/\d/.test(password)) score++;
    if (/[@$!%*?&]/.test(password)) score++;
    return Math.min(score - 1, 3);
}

// Pincode lookup
function lookupPincode(pincode) {
    if (validate('pincode', pincode)) {
        const data = pincodeData[pincode];
        if (data) {
            document.getElementById('city').value = data.city;
            document.getElementById('state').value = data.state;
            showSuccess('city');
            showSuccess('state');
        } else {
            showError('pincode', 'Pincode not found');
        }
    }
}

// Check form validity
function checkFormValidity() {
    const fields = ['candidateName', 'username', 'password', 'email', 'phone', 'pincode', 'city', 'state', 'graduationYear', 'resumeUrl'];
    const terms = document.getElementById('terms').checked;
    
    let valid = terms;
    fields.forEach(field => {
        const element = document.getElementById(field);
        if (!element.classList.contains('valid')) {
            valid = false;
        }
    });
    
    document.getElementById('submitBtn').disabled = !valid;
}

// Event listeners
document.getElementById('candidateName').addEventListener('blur', (e) => { validate('candidateName', e.target.value); checkFormValidity(); });
document.getElementById('username').addEventListener('blur', (e) => checkUsername(e.target.value));
document.getElementById('password').addEventListener('input', (e) => { checkPasswordStrength(e.target.value); if(e.target.value) validate('password', e.target.value); checkFormValidity(); });
document.getElementById('email').addEventListener('blur', (e) => checkEmail(e.target.value));
document.getElementById('phone').addEventListener('blur', (e) => { validate('phone', e.target.value); checkFormValidity(); });
document.getElementById('pincode').addEventListener('blur', (e) => lookupPincode(e.target.value));
document.getElementById('graduationYear').addEventListener('blur', (e) => { if(e.target.value >= 2020 && e.target.value <= 2030) showSuccess('graduationYear'); else showError('graduationYear', 'Year 2020-2030'); checkFormValidity(); });
document.getElementById('resumeUrl').addEventListener('blur', (e) => { validate('resumeUrl', e.target.value); checkFormValidity(); });
document.getElementById('terms').addEventListener('change', checkFormValidity);

// Form submission
document.getElementById('registrationForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Submitting...';
    
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData);
    data.id = 'JF' + Date.now().toString().slice(-6);
    
    // Save to localStorage
    localStorage.setItem('jobFairRegistration', JSON.stringify(data));
    
    setTimeout(() => {
        document.getElementById('confirmationNumber').textContent = data.id;
        document.getElementById('successMessage').classList.add('show');
        submitBtn.textContent = 'Register';
    }, 1500);
});

// Reset form
document.getElementById('resetBtn').addEventListener('click', () => {
    if (confirm('Reset form?')) {
        document.getElementById('registrationForm').reset();
        document.querySelectorAll('.error-message').forEach(el => el.style.display = 'none');
        document.querySelectorAll('input').forEach(el => el.classList.remove('valid', 'invalid'));
        document.querySelectorAll('.status-message').forEach(el => el.textContent = '');
        document.getElementById('passwordStrength').className = 'strength-indicator';
        checkFormValidity();
    }
});

// Close success message
document.getElementById('successMessage').addEventListener('click', () => {
    document.getElementById('successMessage').classList.remove('show');
});

// Initialize
checkFormValidity();