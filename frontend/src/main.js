const statusEl = document.getElementById('status');

fetch('/api/health')
    .then((res) => res.json())
    .then((data) => {
        statusEl.textContent = `status: ${data.status}`;
    })
    .catch(() => {
        statusEl.textContent = 'status: unreachable';
    });
