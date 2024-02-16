const matibabu_saratani = document.getElementById("matibabu_saratani");
const matibabu1 = document.getElementById("matibabu1");

// console.log(type_smoked);

function showElement() {
  if (matibabu_saratani.value === "1") {
    matibabu1.style.display = "block";
  } else {
    matibabu1.style.display = "none";
  }

  // Save the selected value in localStorage
  localStorage.setItem("selectedValue", matibabu_saratani.value);
}

// Check if there's a previously selected value in localStorage
const matibabu_sarataniValue = localStorage.getItem("selectedValue");

if (matibabu_sarataniValue) {
  matibabu_saratani.value = matibabu_sarataniValue;
}

// Show element if Option 2 is selected
showElement();

// Listen for changes in the dropdown
matibabu_saratani.addEventListener("change", showElement);
