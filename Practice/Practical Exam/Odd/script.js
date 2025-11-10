// Validation patterns
const patterns = {
    fullName: /^[A-Za-z][A-Za-z\s]{2,}$/,
    emailAddress: /^[\w.%+-]+@[\w.-]+\.[A-Za-z]{2,}$/,
    phoneNumber: /^(\+91[-\s]?)?[6-9]\d{9}$/,
    collegeId: /^[A-Za-z]{2,4}\d{4}\d{3,4}$/,
    collegeName: /^[A-Za-z][A-Za-z\s.,&'-]{4,}$/,
    motivation: /^.{20,200}$/
};

// Track descriptions
const trackDescs = {
    'web-development': 'Build responsive web applications using HTML, CSS, JavaScript',
    'mobile-app': 'Create mobile applications for iOS and Android platforms',
    'ai-ml': 'Develop AI and Machine Learning solutions for real-world problems',
    'data-science': 'Analyze data and create insights using data science techniques',
    'cybersecurity': 'Implement security solutions and ethical hacking practices',
    'game-development': 'Design and develop interactive games and simulations'
};

let registrationData = {};

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

// Show status
function showStatus(field, message, type) {
    const status = document.getElementById(field + 'Status');
    if (status) {
        status.textContent = message;
        status.className = 'status-message ' + type;
    }
}

// Validate field
function validate(field, value) {
    if (!value.trim()) {
        showError(field, 'Required');
        return false;
    }
    if (patterns[field] && !patterns[field].test(value)) {
        const messages = {
            fullName: 'Name: 3+ chars, start with letter',
            emailAddress: 'Valid email required',
            phoneNumber: 'Valid Indian phone required',
            collegeId: 'Format: CSE2021001',
            collegeName: 'College name: 5+ chars',
            motivation: '20-200 characters required'
        };
        showError(field, messages[field]);
        return false;
    }
    showSuccess(field);
    return true;
}

// Validate select
function validateSelect(field) {
    const value = document.getElementById(field).value;
    if (!value) {
        showError(field, 'Please select');
        return false;
    }
    showSuccess(field);
    return true;
}

// Check email uniqueness
async function checkEmail(email) {
    if (!validate('emailAddress', email)) return;
    showStatus('emailAddress', 'Checking...', 'checking');
    
    setTimeout(() => {
        const existing = ['test@example.com', 'admin@college.edu'];
        if (existing.includes(email.toLowerCase())) {
            showError('emailAddress', 'Email already registered');
            showStatus('emailAddress', 'Already exists', 'unavailable');
        } else {
            showStatus('emailAddress', 'Available', 'available');
        }
    }, 1000);
}

// Check college ID
async function checkCollegeId(id) {
    if (!validate('collegeId', id)) return;
    showStatus('collegeId', 'Verifying...', 'checking');
    
    setTimeout(() => {
        const match = id.match(/^([A-Za-z]{2,4})(\d{4})(\d{3,4})$/);
        if (match) {
            const [, dept, year] = match;
            const validDepts = ['CSE', 'IT', 'ECE', 'BCA', 'MCA'];
            const currentYear = new Date().getFullYear();
            const studentYear = parseInt(year);
            
            if (validDepts.includes(dept.toUpperCase()) && 
                studentYear >= currentYear - 6 && studentYear <= currentYear) {
                showStatus('collegeId', `Valid ${dept.toUpperCase()} ${year}`, 'available');
            } else {
                showError('collegeId', 'Invalid department or year');
                showStatus('collegeId', 'Invalid', 'unavailable');
            }
        } else {
            showError('collegeId', 'Invalid format');
            showStatus('collegeId', 'Invalid', 'unavailable');
        }
    }, 800);
}

// Handle track selection
function handleTrack(track) {
    const desc = document.getElementById('trackDescription');
    if (track && trackDescs[track]) {
        desc.textContent = trackDescs[track];
        desc.classList.add('show');
    } else {
        desc.classList.remove('show');
    }
}

// Handle team size
function handleTeamSize(size) {
    const section = document.getElementById('teamMembersSection');
    const list = document.getElementById('teamMembersList');
    
    if (parseInt(size) > 1) {
        section.classList.add('show');
        list.innerHTML = '';
        
        for (let i = 2; i <= parseInt(size); i++) {
            list.innerHTML += `
                <div class="team-input">
                    <label>Member ${i}:</label>
                    <input type="text" name="member${i}" placeholder="Full Name" required>
                </div>
            `;
        }
    } else {
        section.classList.remove('show');
    }
    checkFormValidity();
}

// Character count
function updateCharCount() {
    const motivation = document.getElementById('motivation');
    const count = document.getElementById('motivationCount');
    count.textContent = motivation.value.length;
    
    if (motivation.value.length > 180) {
        count.style.color = '#dc3545';
    } else if (motivation.value.length > 140) {
        count.style.color = '#ffc107';
    } else {
        count.style.color = '#666';
    }
}

// Check form validity
function checkFormValidity() {
    const required = ['fullName', 'emailAddress', 'phoneNumber', 'collegeId', 'collegeName', 'course', 'yearOfStudy', 'participationTrack', 'teamSize', 'motivation'];
    const terms = document.getElementById('agreeTerms').checked;
    
    let valid = terms;
    required.forEach(field => {
        const element = document.getElementById(field);
        if (!element.classList.contains('valid')) {
            valid = false;
        }
    });
    
    // Check team members
    const teamSize = parseInt(document.getElementById('teamSize').value);
    if (teamSize > 1) {
        const teamInputs = document.querySelectorAll('#teamMembersList input');
        teamInputs.forEach(input => {
            if (!input.value.trim()) valid = false;
        });
    }
    
    document.getElementById('submitRegistration').disabled = !valid;
}

// Download JSON
function downloadJSON(data) {
    const blob = new Blob([JSON.stringify(data, null, 2)], {type: 'application/json'});
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `techfest-${data.id}.json`;
    a.click();
    URL.revokeObjectURL(url);
}

// Event listeners
document.getElementById('fullName').addEventListener('blur', (e) => { validate('fullName', e.target.value); checkFormValidity(); });
document.getElementById('emailAddress').addEventListener('blur', (e) => checkEmail(e.target.value));
document.getElementById('phoneNumber').addEventListener('blur', (e) => { validate('phoneNumber', e.target.value); checkFormValidity(); });
document.getElementById('collegeId').addEventListener('blur', (e) => checkCollegeId(e.target.value));
document.getElementById('collegeName').addEventListener('blur', (e) => { validate('collegeName', e.target.value); checkFormValidity(); });
document.getElementById('course').addEventListener('change', (e) => { validateSelect('course'); checkFormValidity(); });
document.getElementById('yearOfStudy').addEventListener('change', (e) => { validateSelect('yearOfStudy'); checkFormValidity(); });
document.getElementById('participationTrack').addEventListener('change', (e) => { validateSelect('participationTrack'); handleTrack(e.target.value); checkFormValidity(); });
document.getElementById('teamSize').addEventListener('change', (e) => { validateSelect('teamSize'); handleTeamSize(e.target.value); });
document.getElementById('motivation').addEventListener('input', updateCharCount);
document.getElementById('motivation').addEventListener('blur', (e) => { validate('motivation', e.target.value); checkFormValidity(); });
document.getElementById('agreeTerms').addEventListener('change', checkFormValidity);

// Form submission
document.getElementById('techfestForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const submitBtn = document.getElementById('submitRegistration');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Submitting...';
    
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData);
    
    // Get team members
    const teamSize = parseInt(data.teamSize);
    if (teamSize > 1) {
        data.teamMembers = [];
        for (let i = 2; i <= teamSize; i++) {
            if (data[`member${i}`]) {
                data.teamMembers.push(data[`member${i}`]);
            }
        }
    }
    
    data.id = 'TF' + Date.now().toString().slice(-6);
    registrationData = data;
    
    // Simulate submission
    setTimeout(() => {
        document.getElementById('registrationId').textContent = data.id;
        document.getElementById('successMessage').classList.add('show');
        e.target.reset();
        document.getElementById('trackDescription').classList.remove('show');
        document.getElementById('teamMembersSection').classList.remove('show');
        updateCharCount();
        checkFormValidity();
        submitBtn.disabled = false;
        submitBtn.textContent = 'Register';
    }, 1500);
});

// Reset form
document.getElementById('resetForm').addEventListener('click', () => {
    if (confirm('Reset form?')) {
        document.getElementById('techfestForm').reset();
        document.querySelectorAll('.error-message').forEach(el => el.style.display = 'none');
        document.querySelectorAll('input, select, textarea').forEach(el => el.classList.remove('valid', 'invalid'));
        document.querySelectorAll('.status-message').forEach(el => el.textContent = '');
        document.getElementById('trackDescription').classList.remove('show');
        document.getElementById('teamMembersSection').classList.remove('show');
        updateCharCount();
        checkFormValidity();
    }
});

// Download JSON
document.getElementById('downloadJSON').addEventListener('click', () => {
    downloadJSON(registrationData);
});

// Close success message
document.getElementById('successMessage').addEventListener('click', () => {
    document.getElementById('successMessage').classList.remove('show');
});

// Initialize
updateCharCount();
checkFormValidity();