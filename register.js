document.addEventListener("DOMContentLoaded", () => {
    const userTypeSelect = document.getElementById("userType");
    const officerFields = document.querySelector(".officer-fields");
    const officerInputs = officerFields.querySelectorAll("input, textarea, select");

    userTypeSelect.addEventListener("change", () => {
        if (userTypeSelect.value === "Officer") {
            officerFields.style.display = "block"; // Show officer fields
            // Add 'required' attribute to Officer-specific fields
            officerInputs.forEach(input => input.required = true);
        } else {
            officerFields.style.display = "none"; // Hide officer fields
            // Remove 'required' attribute from Officer-specific fields
            officerInputs.forEach(input => input.required = false);
        }
    });
});
