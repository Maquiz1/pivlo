const uchunguzi_maana = document.getElementById("uchunguzi_maana");
const uchunguzi_maana_other = document.getElementById("uchunguzi_maana_other");

// console.log(type_smoked);

function showElement() {
  if (uchunguzi_maana.value === "96") {
    uchunguzi_maana_other.style.display = "block";
  } else {
    uchunguzi_maana_other.style.display = "none";
  }

  // Save the selected value in localStorage
  localStorage.setItem("selectedValue", uchunguzi_maana.value);
}

// Check if there's a previously selected value in localStorage
const uchunguzi_maanaValue = localStorage.getItem("selectedValue");

if (uchunguzi_maanaValue) {
  uchunguzi_maana.value = uchunguzi_maanaValue;
}

// Show element if Option 2 is selected
showElement();

// Listen for changes in the dropdown
uchunguzi_maana.addEventListener("change", showElement);
