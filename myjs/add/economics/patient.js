const income_patient = document.getElementById('income_patient');
const income_patient_other = document.getElementById('income_patient_other');

function showElement() {
  if (income_patient.value === "96") {
    income_patient_other.style.display = "block";
  } else {
    income_patient_other.style.display = "none";
  }

  // Save the selected value in localStorage
  localStorage.setItem("selectedValue", income_patient.value);
}

// Check if there's a previously selected value in localStorage
const income_patientValue = localStorage.getItem("selectedValue");

if (income_patientValue) {
  income_patient.value = income_patientValue;
}

// Show element if Option 2 is selected
showElement();

// Listen for changes in the dropdown
income_patient.addEventListener("change", showElement);
