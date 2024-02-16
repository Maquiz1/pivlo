const wapi_matibabu = document.getElementById("wapi_matibabu");
const wapi_matibabu_other = document.getElementById("wapi_matibabu_other");

// console.log(type_smoked);

function showElement() {
  if (wapi_matibabu.value === "96") {
    wapi_matibabu_other.style.display = "block";
  } else {
    wapi_matibabu_other.style.display = "none";
  }

  // Save the selected value in localStorage
  localStorage.setItem("selectedValue", wapi_matibabu.value);
}

// Check if there's a previously selected value in localStorage
const wapi_matibabuValue = localStorage.getItem("selectedValue");

if (wapi_matibabuValue) {
  wapi_matibabu.value = wapi_matibabuValue;
}

// Show element if Option 2 is selected
showElement();

// Listen for changes in the dropdown
wapi_matibabu.addEventListener("change", showElement);
