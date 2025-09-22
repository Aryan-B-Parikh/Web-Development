document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.registration-form');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
            }
        });

        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
        });
    }

    function validateForm() {
        let isValid = true;
        const fields = ['fullname', 'studentid', 'email', 'phone', 'major', 'year'];
        
        fields.forEach(fieldId => {
            if (!validateField(document.getElementById(fieldId))) {
                isValid = false;
            }
        });

        const terms = document.getElementById('terms');
        if (!terms.checked) {
            showError('terms', 'You must agree to the terms and conditions');
            isValid = false;
        } else {
            clearError('terms');
        }

        return isValid;
    }

    function validateField(field) {
        if (!field) return true;

        const value = field.value.trim();
        const fieldId = field.id;
        let isValid = true;

        clearError(fieldId);

        switch (fieldId) {
            case 'fullname':
                if (value.length < 2) {
                    showError(fieldId, 'Full name must be at least 2 characters long');
                    isValid = false;
                } else if (!/^[a-zA-Z\s]+$/.test(value)) {
                    showError(fieldId, 'Full name should contain only letters and spaces');
                    isValid = false;
                }
                break;

            case 'studentid':
                if (!/^[a-zA-Z0-9]{4,20}$/.test(value)) {
                    showError(fieldId, 'Student ID must be 4-20 alphanumeric characters');
                    isValid = false;
                }
                break;

            case 'email':
                if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                    showError(fieldId, 'Please enter a valid email address');
                    isValid = false;
                }
                break;

            case 'phone':
                if (!/^[0-9+\-\s]{10,15}$/.test(value)) {
                    showError(fieldId, 'Please enter a valid phone number (10-15 digits)');
                    isValid = false;
                }
                break;

            case 'major':
            case 'year':
                if (value === '') {
                    showError(fieldId, 'Please select an option');
                    isValid = false;
                }
                break;
        }

        return isValid;
    }

    function showError(fieldId, message) {
        const errorElement = document.getElementById(fieldId + '-error');
        const field = document.getElementById(fieldId);
        
        if (errorElement) {
            errorElement.textContent = message;
        }
        
        if (field) {
            field.style.borderColor = '#e74c3c';
        }
    }

    function clearError(fieldId) {
        const errorElement = document.getElementById(fieldId + '-error');
        const field = document.getElementById(fieldId);
        
        if (errorElement) {
            errorElement.textContent = '';
        }
        
        if (field) {
            field.style.borderColor = '#e0e6ed';
        }
    }

    const searchForm = document.querySelector('.search-form');
    if (searchForm) {
        const queryInput = searchForm.querySelector('#query');
        if (queryInput) {
            queryInput.addEventListener('input', function() {
                const button = searchForm.querySelector('.btn-search');
                if (this.value.trim().length > 0) {
                    button.style.background = 'linear-gradient(135deg, #27ae60, #2ecc71)';
                } else {
                    button.style.background = '#95a5a6';
                }
            });
        }
    }

    const cards = document.querySelectorAll('.registration-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.borderLeftWidth = '6px';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.borderLeftWidth = '4px';
        });
    });
});