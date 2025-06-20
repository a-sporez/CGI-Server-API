import { login, logout, onLoginSuccess } from "./auth.js";
import { fetchUsers } from "./users.js";

const loginForm = document.getElementById('loginForm');
const logoutBtn = document.getElementById('logoutBtn');

loginForm.addEventListener('submit', async (event) => {
    event.preventDefault();
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    const success = await login(username, password);
    if (success) {
        onLoginSuccess(username);
        fetchUsers();
    } else {
        alert("Login Failed.");
    }
});

logoutBtn.addEventListener('click', () => {
    logout();
});