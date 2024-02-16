const dalili_saratani = document.getElementById("dalili_saratani");
const dalili_saratani_other = document.getElementById("dalili_saratani_other");

// console.log(type_smoked);

function showElement() {
  if (dalili_saratani.value === "96") {
    dalili_saratani_other.style.display = "block";
  } else {
    dalili_saratani_other.style.display = "none";
  }

  // Save the selected value in localStorage
  localStorage.setItem("selectedValue", dalili_saratani.value);
}

// Check if there's a previously selected value in localStorage
const dalili_sarataniValue = localStorage.getItem("selectedValue");

if (dalili_sarataniValue) {
  dalili_saratani.value = dalili_sarataniValue;
}

// Show element if Option 2 is selected
showElement();

// Listen for changes in the dropdown
dalili_saratani.addEventListener("change", showElement);
