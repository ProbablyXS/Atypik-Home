// Get the form element, checkboxes, and select boxes
const form = document.getElementById('filterForm');
const checkboxes = document.querySelectorAll("input[type=checkbox]");
const selects = form.querySelectorAll("select"); // Select only within the form

// Function to construct the URL based on checkbox and select values
function constructURL() {
    let url = "?";

    checkboxes.forEach(cb => {
        const cbName = cb.getAttribute("name");
        const updatedName = cbName.replace(/^rentals_filter_form\[(.*?)\]$/, '$1');
        if (cb.checked) {
            url += `${updatedName}=1&`;
        }
    });

    selects.forEach(select => {
        const selectName = select.getAttribute("name");
        const selectValue = select.value;
        const updatedName = selectName.replace(/^rentals_filter_form\[(.*?)\]$/, '$1');
        if (selectValue) {
            url += `${updatedName}=${selectValue}&`;
        }
    });

    // Remove the trailing '&' character if it exists
    if (url.endsWith("&")) {
        url = url.slice(0, -1);
    }

    return url;
}

// Function to handle form submission
function submitForm() {
    const url = constructURL();

    // Redirect to the updated URL
    window.location.href = url;
}

// Function to load and set the checkbox states from localStorage on page load
function loadCheckboxStates() {
    checkboxes.forEach(checkbox => {
        const checkboxName = checkbox.getAttribute("name");
        const storedState = localStorage.getItem(`${checkboxName}CheckboxState`);
        if (storedState === "true") {
            checkbox.checked = true;
        }

        // Add an event listener to each checkbox
        checkbox.addEventListener("change", function (event) {
            // Prevent the default behavior of the checkbox
            event.preventDefault();

            // Store the checkbox state in localStorage
            localStorage.setItem(`${checkboxName}CheckboxState`, checkbox.checked);

            submitForm(); // Submit the form when a checkbox is changed
        });
    });
}

// Function to load and set the select states from localStorage on page load
function loadSelectStates() {
    selects.forEach(select => {
        const selectName = select.getAttribute("name");
        const storedValue = localStorage.getItem(`${selectName}SelectState`);
        if (storedValue !== null) {
            select.value = storedValue;
        }

        // Add an event listener to each select box
        select.addEventListener("change", function (event) {
            // Store the select value in localStorage
            localStorage.setItem(`${selectName}SelectState`, select.value);

            submitForm(); // Submit the form when a select box is changed
        });
    });
}

// Call the loadCheckboxStates and loadSelectStates functions on page load
window.addEventListener('load', function () {
    loadCheckboxStates();
    loadSelectStates();
});

// Add a submit event listener to the form
form.addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent the default form submission
    submitForm();
});

document.addEventListener("DOMContentLoaded", function () {
    var btnHamb = document.querySelector(".input-filter");

    btnHamb.addEventListener("click", function () {

        if (form.className === "hide") {
            document.getElementById("filterForm").className = ("show");
        } else {
            document.getElementById("filterForm").className = ("hide");
        }
    });
});