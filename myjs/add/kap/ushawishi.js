const ushawishi = document.getElementById("ushawishi");
const ushawishi_other = document.getElementById("ushawishi_other");

// console.log(type_smoked);

function showElement() {
  if (ushawishi.value === "96") {
    ushawishi_other.style.display = "block";
  } else {
    ushawishi_other.style.display = "none";
  }

  // Save the selected value in localStorage
  localStorage.setItem("selectedValue", ushawishi.value);
}

// Check if there's a previously selected value in localStorage
const ushawishiValue = localStorage.getItem("selectedValue");

if (ushawishiValue) {
  ushawishi.value = ushawishiValue;
}

// Show element if Option 2 is selected
showElement();

// Listen for changes in the dropdown
ushawishi.addEventListener("change", showElement);
