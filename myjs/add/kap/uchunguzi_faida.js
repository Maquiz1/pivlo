const uchunguzi_faida = document.getElementById("uchunguzi_faida");
const saratani_hatari1 = document.getElementById("uchunguzi_faida_other");

// console.log(type_smoked);

function showElement() {
  if (uchunguzi_faida.value === "96") {
    saratani_hatari1.style.display = "block";
  } else {
    saratani_hatari1.style.display = "none";
  }

  // Save the selected value in localStorage
  localStorage.setItem("selectedValue", uchunguzi_faida.value);
}

// Check if there's a previously selected value in localStorage
const uchunguzi_faidaValue = localStorage.getItem("selectedValue");

if (uchunguzi_faidaValue) {
  uchunguzi_faida.value = uchunguzi_faidaValue;
}

// Show element if Option 2 is selected
showElement();

// Listen for changes in the dropdown
uchunguzi_faida.addEventListener("change", showElement);
