const ever_smoked1 = document.getElementById("ever_smoked1");
const ever_smoked2 = document.getElementById("ever_smoked2");

const start_smoking = document.getElementById("start_smoking");
const currently_smoking = document.getElementById("currently_smoking");
const ever_smoked = document.getElementById("ever_smoked");

function toggleElementVisibility() {
  if (ever_smoked1.checked) {
    start_smoking.style.display = "block";
    currently_smoking.style.display = "block";
    ever_smoked.style.display = "block";
  } else {
    start_smoking.style.display = "none";
    currently_smoking.style.display = "none";
    ever_smoked.style.display = "none";
  }
}

ever_smoked1.addEventListener("change", toggleElementVisibility);
ever_smoked2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();
