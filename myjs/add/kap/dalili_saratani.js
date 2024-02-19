document.addEventListener("DOMContentLoaded", function () {
  const dalili_saratani = document.getElementById("dalili_saratani");
  const dalili_saratani_other = document.getElementById(
    "dalili_saratani_other"
  );

  if (dalili_saratani.checked && dalili_saratani.value === "96") {
    dalili_saratani_other.style.display = "block";
  } else {
    dalili_saratani_other.style.display = "none";
  }
});
