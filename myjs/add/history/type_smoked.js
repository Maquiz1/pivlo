const type_smoked1 = document.getElementById("type_smoked1");
const type_smoked2 = document.getElementById("type_smoked2");

const packs_per_day = document.getElementById("packs_per_day");
const cigarette_per_day = document.getElementById("cigarette_per_day");

function toggleElementVisibility() {
  if (type_smoked1.checked) {
    packs_per_day.style.display = "block";
  } else if (type_smoked2.checked) {
    cigarette_per_day.style.display = "block";
  } else {
    packs_per_day.style.display = "none";
    cigarette_per_day.style.display = "none";
  }
}

ever_smoked1.addEventListener("change", toggleElementVisibility);
ever_smoked2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
