document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("studentForm");
    const tableBody = document.querySelector("#studentTable tbody");

    form.addEventListener("submit", async (event) => {
        event.preventDefault();
        const formData = new FormData(form);
        const data = {};
        formData.forEach((value, key) => (data[key] = value));

        // Send the data to the server
        const response = await fetch("/api/v1/student", {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(data),
        });

        if (response.ok) {
            // Reload the student data
            loadStudents();
        } else {
            alert("Failed to add student.");
        }
    });

    async function loadStudents() {
        const response = await fetch("/api/v1/student", {
            headers: {
                "Accept": "application/json",
            },
        });

        if (response.ok) {
            const students = await response.json();
            tableBody.innerHTML = "";
            students.forEach((student) => {
                const row = document.createElement("tr");
                Object.values(student).forEach((value) => {
                    const cell = document.createElement("td");
                    cell.textContent = value;
                    row.appendChild(cell);
                });
                tableBody.appendChild(row);
            });
        } else {
            alert("Failed to load students.");
        }
    }

    // Load students on page load
    loadStudents();
});

