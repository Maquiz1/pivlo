const insurance_name = document.getElementById("insurance_name");
const insurance_name_other = document.getElementById("insurance_name_other");

function showElement() {
  if (insurance_name.value === "96") {
    insurance_name_other.style.display = "block";
  } else {
    insurance_name_other.style.display = "none";
  }

  // Save the selected value in localStorage
  localStorage.setItem("selectedValue", insurance_name.value);
}

// Check if there's a previously selected value in localStorage
const insurance_nameValue = localStorage.getItem("selectedValue");

if (insurance_nameValue) {
  insurance_name.value = insurance_nameValue;
}

// Show element if Option 2 is selected
showElement();

// Listen for changes in the dropdown
insurance_name.addEventListener("change", showElement);