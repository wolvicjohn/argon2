// script.js

// Get the modal
const modal = document.getElementById('modal');

// Get the button that opens the modal
const btn = document.getElementById('openModal');

// Get the <span> element that closes the modal
const span = document.getElementsByClassName('close')[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = 'block';
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = 'none';
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}

// Password strength functionality
const passwordInput = document.getElementById('password');
const strengthBar = document.getElementById('strength-bar');
const strengthText = document.getElementById('strength-text');

passwordInput.addEventListener('input', () => {
    const password = passwordInput.value;
    const strength = calculateStrength(password);
    updateStrengthMeter(strength);
});

function calculateStrength(password) {
    let strength = 0;

    if (password.length >= 8) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;

    return strength;
}

function updateStrengthMeter(strength) {
    // Reset the strength bar
    strengthBar.className = 'strength-bar';
    strengthBar.style.width = `${strength * 20}%`;  // Dynamically set the width

    // Set the color and text based on strength
    if (strength <= 1) {
        strengthBar.classList.add('strength-weak');
        strengthText.textContent = 'Weak';
        strengthText.style.color = 'red';
    } else if (strength <= 3) {
        strengthBar.classList.add('strength-medium');
        strengthText.textContent = 'Medium';
        strengthText.style.color = 'orange';
    } else {
        strengthBar.classList.add('strength-strong');
        strengthText.textContent = 'Strong';
        strengthText.style.color = 'green';
    }
}
