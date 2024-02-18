const income_household = document.getElementById('income_household');
const income_household_other = document.getElementById('income_household_other');

function showElement() {
  if (income_household.value === "96") {
    income_household_other.style.display = "block";
  } else {
    income_household_other.style.display = "none";
  }

  // Save the selected value in localStorage
  localStorage.setItem("selectedValue", income_household.value);
}

// Check if there's a previously selected value in localStorage
const income_householdValue = localStorage.getItem("selectedValue");

if (income_householdValue) {
  income_household.value = income_householdValue;
}

// Show element if Option 2 is selected
showElement();

// Listen for changes in the dropdown
income_household.addEventListener("change", showElement);
