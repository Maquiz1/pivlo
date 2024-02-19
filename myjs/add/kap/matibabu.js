const matibabu1 = document.getElementById("matibabu1");
const matibabu_other = document.getElementById("matibabu_other");

matibabu1.addEventListener("change", function () {
  if (this.checked) {
    matibabu_other.style.display = "block";
  } else {
    matibabu_other.style.display = "none";
  }
});




