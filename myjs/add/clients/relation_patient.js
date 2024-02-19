const relation_patient = document.getElementById("relation_patient");
const relation_patient_other = document.getElementById(
  "relation_patient_other"
);

function showElement() {
  if (relation_patient.value === "96") {
    relation_patient_other.style.display = "block";
  } else {
    relation_patient_other.style.display = "none";
  }

  // Save the selected value in localStorage
  localStorage.setItem("selectedValue", relation_patient.value);

  // // Check if the elementToShow is hidden and the selected value is the hidden value
  // if (elementToShow.style.display === "none" && dropdown.value === "96") {
  //   // Reset dropdown value to default or another appropriate action
  //   dropdown.value = "2";
  //   alert("Other is not available.");
  // }
}

// Check if there's a previously selected value in localStorage
const relation_patientValue = localStorage.getItem("selectedValue");

if (relation_patientValue) {
  relation_patient.value = relation_patientValue;
}

// Show element if Option 2 is selected
showElement();

// Listen for changes in the dropdown
relation_patient.addEventListener("change", showElement);

// // Sample options data
// const optionsData = [
//   { value: "1", text: "Option 1" },
//   { value: "2", text: "Option 2" },
//   { value: "3", text: "Option 3" },
// ];

// // Get select element
// const selectElement = document.getElementById("relation_patient");

// // Populate select options
// optionsData.forEach((option) => {
//   const optionElement = document.createElement("option");
//   optionElement.value = option.value;
//   optionElement.textContent = option.text;
//   selectElement.appendChild(optionElement);
// });
