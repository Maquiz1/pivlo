const vitu_hatarishi = document.getElementById("vitu_hatarishi");
const vitu_hatarishi_other = document.getElementById("vitu_hatarishi_other");

// console.log(type_smoked);

function showElement() {
  if (vitu_hatarishi.value === "96") {
    vitu_hatarishi_other.style.display = "block";
  } else {
    vitu_hatarishi_other.style.display = "none";
  }

  // Save the selected value in localStorage
  localStorage.setItem("selectedValue", vitu_hatarishi.value);
}

// Check if there's a previously selected value in localStorage
const vitu_hatarishiValue = localStorage.getItem("selectedValue");

if (vitu_hatarishiValue) {
  vitu_hatarishi.value = vitu_hatarishiValue;
}

// Show element if Option 2 is selected
showElement();

// Listen for changes in the dropdown
vitu_hatarishi.addEventListener("change", showElement);
