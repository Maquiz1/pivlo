const type_smoked1 = document.getElementById("type_smoked1");
const type_smoked2 = document.getElementById("type_smoked2");
const type_smoked = document.getElementById("type_smoked");

const packs_per_day = document.getElementById("packs_per_day");
const cigarette_per_day = document.getElementById("cigarette_per_day");

function toggleElementVisibility() {
  if (type_smoked1.checked) {
    packs_per_day.style.display = "block";
    cigarette_per_day.style.display = "none";
  } else if (type_smoked2.checked) {
    packs_per_day.style.display = "none";
    cigarette_per_day.style.display = "block";
  } else {
    packs_per_day.style.display = "none";
    cigarette_per_day.style.display = "none";
  }
}

type_smoked1.addEventListener("change", toggleElementVisibility);
type_smoked2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
