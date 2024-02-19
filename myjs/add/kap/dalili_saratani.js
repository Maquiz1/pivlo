const dalili_saratani = document.getElementById("dalili_saratani");
const dalili_saratani_other = document.getElementById("dalili_saratani_other");

dalili_saratani.addEventListener("change", function () {
  if (this.checked) {
    dalili_saratani_other.style.display = "block";
  } else {
    dalili_saratani_other.style.display = "none";
  }
});
