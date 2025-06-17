document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
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
    }

    // Form validation
    const loginForm = document.getElementById('adminLoginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            
            if (!username) {
                alert('Username harus diisi!');
                return;
            }
            
            if (password.length < 6) {
                alert('Password minimal 6 karakter!');
                return;
            }
            
            // Simulate admin login
            console.log('Admin login attempt:', { username, password });
            alert('Login berhasil! Mengarahkan ke dashboard admin...');
            // window.location.href = '/admin/dashboard';
        });
    }
});