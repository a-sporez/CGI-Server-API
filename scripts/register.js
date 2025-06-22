const form      = document.getElementById('registerForm');
const message   = document.getElementById('registerMessage');

form.addEventListener('submit', async (event) => {
    event.preventDefault();
    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value.trim();

    if (!username || !password) {
        message.textContent = "Username and password required.";
        return;
    }

    const res = await fetch('./api/routes/users.php', {
        method: 'POST',
        header: {'Content-Type': "application/json"},
        body: JSON.stringify({username, password})
    });

    const data = await res.json();

    if (data.success) {
        message.style.color = 'var(--link-color)';
        message.textContent = 'Registration Successful.';
        form.reset();
    } else {
        message.style.color = 'red';
        message.textContent = data.error || 'Registration failed.';
    }
});