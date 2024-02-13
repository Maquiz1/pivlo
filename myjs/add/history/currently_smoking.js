const currently_smoking = document.getElementById("currently_smoking");
const quit_smoking = document.getElementById("quit_smoking");

// console.log(type_smoked);

function showElement() {
  if (currently_smoking.value === "1") {
    quit_smoking.style.display = "block";
  } else if (currently_smoking.value === "2") {
    quit_smoking.style.display = "none";
  } else {
    quit_smoking.style.display = "none";
  }

  // Save the selected value in localStorage
  localStorage.setItem("selectedValue", currently_smoking.value);
}

// Check if there's a previously selected value in localStorage
const currently_smokingValue = localStorage.getItem("selectedValue");

if (currently_smokingValue) {
  currently_smoking.value = currently_smokingValue;
}

// Show element if Option 2 is selected
showElement();

// Listen for changes in the dropdown
currently_smoking.addEventListener("change", showElement);
