export async function login(username, password) {
    const res = await fetch('/users.php', {
        method: "POST",
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({username, password})
    });

    const data = await res.json();
    return data.success;
}

export function onLoginSuccess(username) {
    document.getElementById('loginForm').style.display = 'none';
    const panel = document.getElementById('userPanel');
    panel.style.display = 'block';
    document.getElementById('userWelcome').textContent = username;
}

export function logout() {
    document.getElementById('loginForm').style.display = 'block';
    document.getElementById('userPanel').style.display = 'none';
}