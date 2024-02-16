const health_insurance = document.getElementById("health_insurance");
const insurance_name1 = document.getElementById("insurance_name1");
const pay_services = document.getElementById("pay_services");

function showElement() {
  if (health_insurance.value === "1") {
    insurance_name1.style.display = "block";
    pay_services.style.display = "none";
  } else if (health_insurance.value === "2") {
    insurance_name1.style.display = "none";
    pay_services.style.display = "block";
  } else {
    insurance_name1.style.display = "none";
    pay_services.style.display = "none";
  }

  // Save the selected value in localStorage
  localStorage.setItem("selectedValue", health_insurance.value);
}

// Check if there's a previously selected value in localStorage
const health_insuranceValue = localStorage.getItem("selectedValue");

if (health_insuranceValue) {
  health_insurance.value = health_insuranceValue;
}

// Show element if Option 2 is selected
showElement();

// Listen for changes in the dropdown
health_insurance.addEventListener("change", showElement);