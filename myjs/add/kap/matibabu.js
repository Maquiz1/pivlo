const matibabu = document.getElementById("matibabu");
const matibabu_other = document.getElementById("matibabu_other");

// console.log(type_smoked);

function showElement() {
  if (matibabu.value === "96") {
    matibabu_other.style.display = "block";
  } else {
    matibabu_other.style.display = "none";
  }

  // Save the selected value in localStorage
  localStorage.setItem("selectedValue", matibabu.value);
}

// Check if there's a previously selected value in localStorage
const matibabuValue = localStorage.getItem("selectedValue");

if (matibabuValue) {
  matibabu.value = matibabuValue;
}

// Show element if Option 2 is selected
showElement();

// Listen for changes in the dropdown
matibabu.addEventListener("change", showElement);
