const visit_status = document.getElementById("visit_status");
const followup = document.getElementById("followup");

function showElement() {
  if (visit_status.value === "1") {
    followup.style.display = "block";
  } else {
    followup.style.display = "none";
  }

  // Save the selected value in localStorage
  localStorage.setItem("selectedValue", visit_status.value);

  // Check if the elementToShow is hidden and the selected value is the hidden value
  if (followup.style.display === "none" && visit_status.value === "1") {
    // Reset dropdown value to default or another appropriate action
    visit_status.value = "2";
    alert("Other is not available.");
  }
}

// Check if there's a previously selected value in localStorage
const visit_statusValue = localStorage.getItem("selectedValue");

if (visit_statusValue) {
  visit_status.value = visit_statusValue;
}

// Show element if Option 2 is selected
showElement();

// Listen for changes in the dropdown
visit_status.addEventListener("change", showElement);
