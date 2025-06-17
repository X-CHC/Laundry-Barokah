// Toggle password visibility
document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordInput = document.getElementById('password');
    const icon = this.querySelector('i');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
});

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    e.preventDefault();
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    
    if (!email.includes('@')) {
        alert('Format email tidak valid!');
        return;
    }
    
    if (password.length < 8) {
        alert('Password harus minimal 8 karakter!');
        return;
    }
    
    // Simulate login
    console.log('Login attempt with:', { email, password });
    alert('Login berhasil! Mengarahkan ke dashboard...');
    // window.location.href = '/dashboard';
});