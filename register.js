document.addEventListener("DOMContentLoaded", () => {
    const userTypeSelect = document.getElementById("userType");
    const officerFields = document.querySelector(".officer-fields");

    userTypeSelect.addEventListener("change", () => {
        if (userTypeSelect.value === "Officer") {
            officerFields.style.display = "block"; // Show officer fields
        } else {
            officerFields.style.display = "none"; // Hide officer fields
        }
    });
});
