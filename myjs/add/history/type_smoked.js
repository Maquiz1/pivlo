const type_smoked = document.getElementById("type_smoked");
const packs_per_day = document.getElementById("packs_per_day");
const cigarette_per_day = document.getElementById("cigarette_per_day");

function showElement() {
  if (type_smoked.value === "1") {
    packs_per_day.style.display = "block";
    cigarette_per_day.style.display = "none";
  } else if (type_smoked.value === "2") {
    packs_per_day.style.display = "block";
    cigarette_per_day.style.display = "none";
  } else {
    packs_per_day.style.display = "none";
    cigarette_per_day.style.display = "none";
  }

  // Save the selected value in localStorage
  localStorage.setItem("selectedValue", type_smoked.value);
}

// Check if there's a previously selected value in localStorage
const type_smokedValue = localStorage.getItem("selectedValue");

if (type_smokedValue) {
  type_smoked.value = type_smokedValue;
}

// Show element if Option 2 is selected
showElement();

// Listen for changes in the dropdown
type_smoked.addEventListener("change", showElement);
