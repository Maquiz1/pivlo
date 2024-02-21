const ever_smoked1 = document.getElementById("ever_smoked1");
const ever_smoked2 = document.getElementById("ever_smoked2");

const ever_smoked = document.getElementById("ever_smoked");

function toggleElementVisibility() {
  if (ever_smoked1.checked) {
    ever_smoked.style.display = "block";
  } else {
    ever_smoked.style.display = "none";
  }
}

ever_smoked1.addEventListener("change", toggleElementVisibility);
ever_smoked2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
