const saratani_vipimo = document.getElementById("saratani_vipimo");
const saratani_vipimo_other = document.getElementById("saratani_vipimo_other");

// console.log(type_smoked);

function showElement() {
  if (saratani_vipimo.value === "96") {
    saratani_vipimo_other.style.display = "block";
  } else {
    saratani_vipimo_other.style.display = "none";
  }

  // Save the selected value in localStorage
  localStorage.setItem("selectedValue", saratani_vipimo.value);
}

// Check if there's a previously selected value in localStorage
const saratani_vipimoValue = localStorage.getItem("selectedValue");

if (saratani_vipimoValue) {
  saratani_vipimo.value = saratani_vipimoValue;
}

// Show element if Option 2 is selected
showElement();

// Listen for changes in the dropdown
saratani_vipimo.addEventListener("change", showElement);

