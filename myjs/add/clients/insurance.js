// function showElement() {
//   if (health_insurance.value === "1") {
//     insurance_name1.style.display = "block";
//     pay_services.style.display = "none";
//   } else if (health_insurance.value === "2") {
//     insurance_name1.style.display = "none";
//     pay_services.style.display = "block";
//   } else {
//     insurance_name1.style.display = "none";
//     pay_services.style.display = "none";
//   }

//   // Save the selected value in localStorage
//   localStorage.setItem("selectedValue", health_insurance.value);
// }

// // Check if there's a previously selected value in localStorage
// const health_insurance1Value = localStorage.getItem("selectedValue");

// if (health_insurance1Value) {
//   health_insurance.value = health_insurance1Value;
// }

// // Show element if Option 2 is selected
// showElement();

// // Listen for changes in the dropdown
// health_insurance.addEventListener("change", showElement);





const health_insurance = document.getElementById("health_insurance");
const insurance_name1 = document.getElementById("insurance_name1");
const pay_services = document.getElementById("pay_services");
const relation_patient_other = document.getElementById(
  "relation_patient_other"
);

function toggleElementVisibility() {
  if (relation_patient96.checked) {
    relation_patient_other.style.display = "block";
  } else {
    relation_patient_other.style.display = "none";
  }
}

relation_patient1.addEventListener("change", toggleElementVisibility);
relation_patient2.addEventListener("change", toggleElementVisibility);
relation_patient3.addEventListener("change", toggleElementVisibility);
relation_patient4.addEventListener("change", toggleElementVisibility);
relation_patient5.addEventListener("change", toggleElementVisibility);
relation_patient96.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();