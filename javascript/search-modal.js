let searchType = null;
let targetField = null;

const input = document.getElementById("searchInput");
const results = document.getElementById("searchResults");
const head = document.getElementById("searchHead");

document.querySelectorAll("[data-search-type]").forEach(btn => {

    btn.addEventListener("click", () => {

        searchType = btn.dataset.searchType;
        targetField = btn.dataset.target;

        input.value = "";
        results.innerHTML = "";

        if (searchType === "user") {
            head.innerHTML = "<tr><th>Name</th><th>Email</th><th></th></tr>";
        }

        if (searchType === "club") {
            head.innerHTML = "<tr><th>Club</th><th>Description</th><th></th></tr>";
        }
    });

});

input.addEventListener("input", async () => {

    if (!searchType || input.value.trim() === "") {
        results.innerHTML = "";
        return;
    }

    const res = await fetch(
        `php/search/${searchType}-search.php?search=${encodeURIComponent(input.value)}`
    );

    const data = await res.json();

    results.innerHTML = data.map(row => {

        if (searchType === "user") {
            return `
            <tr>
                <td>${row.name}</td>
                <td>${row.email}</td>
                <td>
                    <button class="select-result btn btn-sm btn-primary" data-id="${row.user_id}" data-name="${row.name}">Select</button></td>
            </tr>`;
        }

        if (searchType === "club") {
            return `
            <tr>
                <td>${row.club_name}</td>
                <td>${row.description}</td>
                <td>
                    <button class="select-result btn btn-sm btn-primary" data-id="${row.club_id}" data-name="${row.club_name}">Select</button></td>
            </tr>`;
        }

    }).join("");

});

results.addEventListener("click", e => {

    if (!e.target.classList.contains("select-result")) return;

    const display = document.getElementById(`${targetField}_display`);
    const hidden = document.getElementById(`${targetField}_id`);

    if (display && hidden) {
        display.value = e.target.dataset.name;
        hidden.value = e.target.dataset.id;
    }

    bootstrap.Modal.getInstance(
        document.getElementById("searchModal")
    ).hide();

});