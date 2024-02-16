const kundi = document.getElementById("kundi");
const kundi_other = document.getElementById("kundi_other");

// console.log(type_smoked);

function showElement() {
  if (kundi.value === "96") {
    kundi_other.style.display = "block";
  } else {
    kundi_other.style.display = "none";
  }

  // Save the selected value in localStorage
  localStorage.setItem("selectedValue", kundi.value);
}

// Check if there's a previously selected value in localStorage
const kundiValue = localStorage.getItem("selectedValue");

if (kundiValue) {
  kundi.value = kundiValue;
}

// Show element if Option 2 is selected
showElement();

// Listen for changes in the dropdown
kundi.addEventListener("change", showElement);
