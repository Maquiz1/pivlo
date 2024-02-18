const saratani_inatibika = document.getElementById("saratani_inatibika2");
const matibabu_saratani1 = document.getElementById("matibabu_saratani2");

// console.log(type_smoked);

function showElement() {
  if (saratani_inatibika.value === "1") {
    matibabu_saratani1.style.display = "block";
  } else {
    matibabu_saratani1.style.display = "none";
  }

  // Save the selected value in localStorage
  localStorage.setItem("selectedValue", saratani_inatibika.value);
}

// Check if there's a previously selected value in localStorage
const saratani_inatibikaValue = localStorage.getItem("selectedValue");

if (saratani_inatibikaValue) {
  saratani_inatibika.value = saratani_inatibikaValue;
}

// Show element if Option 2 is selected
showElement();

// Listen for changes in the dropdown
saratani_inatibika.addEventListener("change", showElement);
