const uchunguzi_hatari = document.getElementById("uchunguzi_hatari");
const saratani_hatari1 = document.getElementById("saratani_hatari1");

// console.log(type_smoked);

function showElement() {
  if (uchunguzi_hatari.value === "96") {
    uchunguzi_faida_other.style.display = "block";
  } else {
    uchunguzi_faida_other.style.display = "none";
  }

  // Save the selected value in localStorage
  localStorage.setItem("selectedValue", uchunguzi_hatari.value);
}

// Check if there's a previously selected value in localStorage
const uchunguzi_hatariValue = localStorage.getItem("selectedValue");

if (uchunguzi_hatariValue) {
  uchunguzi_hatari.value = uchunguzi_hatariValue;
}

// Show element if Option 2 is selected
showElement();

// Listen for changes in the dropdown
uchunguzi_hatari.addEventListener("change", showElement);
