function validateForm() {
    var name = document.getElementById('name').value;
    var email = document.getElementById('email').value;
    var phone = document.getElementById('phone').value;
    var course = document.getElementById('course').value;
    var year = document.getElementById('year').value;

    if (name === '' || email === '' || phone === '' || course === '' || year === '') {
        alert('Please fill in all fields');
        return false;
    }
    
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert('Please enter a valid email address');
        return false;
    }
    
    var phonePattern = /^[0-9]{10}$/;
    if (!phonePattern.test(phone)) {
        alert('Please enter a valid 10-digit phone number');
        return false;
    }
    
    return true;
}

function showMessage(message, type) {
    var messageDiv = document.createElement('div');
    messageDiv.className = 'message ' + type;
    messageDiv.textContent = message;
    
    document.body.insertBefore(messageDiv, document.body.firstChild);
    
    setTimeout(function() {
        messageDiv.remove();
    }, 3000);
}