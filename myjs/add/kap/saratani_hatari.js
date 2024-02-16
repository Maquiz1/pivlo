const saratani_hatari = document.getElementById("saratani_hatari");
const uchunguzi_faida_other = document.getElementById("saratani_hatari_other");

// console.log(type_smoked);

function showElement() {
  if (saratani_hatari.value === "96") {
    uchunguzi_faida_other.style.display = "block";
  } else {
    uchunguzi_faida_other.style.display = "none";
  }

  // Save the selected value in localStorage
  localStorage.setItem("selectedValue", saratani_hatari.value);
}

// Check if there's a previously selected value in localStorage
const saratani_hatariValue = localStorage.getItem("selectedValue");

if (saratani_hatariValue) {
  saratani_hatari.value = saratani_hatariValue;
}

// Show element if Option 2 is selected
showElement();

// Listen for changes in the dropdown
saratani_hatari.addEventListener("change", showElement);
