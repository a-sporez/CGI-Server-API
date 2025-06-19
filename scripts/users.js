export async function fetchUsers() {
    const res  = await fetch('/users.php');
    const data = await res.json();
    const list = document.getElementById('userList');
    list.innerHTML = "";

    if (Array.isArray(data.data)) {
        data.data.forEach(user => {
            const li = document.createElement('li');
            li.textContent = `${user.username} (${user.role})`;
            list.appendChild(li);
        });
    }
}