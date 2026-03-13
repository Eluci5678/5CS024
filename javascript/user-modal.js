let targetClubId = null;

document.querySelectorAll('[data-target-input]').forEach(btn => {
    btn.addEventListener('click', () => {
        targetClubId = btn.dataset.targetInput;

        const input = document.getElementById("userSearchInput");
        const results = document.getElementById("userSearchResults");
        input.value = "";
        results.innerHTML = "";
    });
});

const input = document.getElementById("userSearchInput");
const results = document.getElementById("userSearchResults");

input.addEventListener("input", async () => {
    if (!targetClubId) return;

    if (input.value.trim() === "") {
        results.innerHTML = "";
        return;
    }

    try {
        const response = await fetch(`php/search/user-search.php?user=${encodeURIComponent(input.value)}`);
        if (!response.ok) throw new Error("Network error");
        const users = await response.json();

        results.innerHTML = users.map(user => `
            <tr>
                <td>${user.name}</td>
                <td>${user.email}</td>
                <td><button class="btn btn-sm btn-primary select-user" data-id="${user.user_id}" data-name="${user.name}">Select</button></td>
            </tr>
        `).join("");
    } catch (err) {
        console.error(err);
        results.innerHTML = "<tr><td colspan='3'>Error loading users</td></tr>";
    }
});

results.addEventListener("click", e => {
    if (!e.target.classList.contains("select-user") || !targetClubId) return;

    const display = document.getElementById(`owner_display_${targetClubId}`);
    const hidden = document.getElementById(`owner_id_${targetClubId}`);

    if (display && hidden) {
        display.value = e.target.dataset.name;
        hidden.value = e.target.dataset.id;
    }

    bootstrap.Modal.getInstance(document.getElementById("userSearchModal")).hide();
});