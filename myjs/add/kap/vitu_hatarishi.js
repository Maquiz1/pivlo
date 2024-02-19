document.addEventListener("DOMContentLoaded", function () {
  const vitu_hatarishi = document.getElementById("vitu_hatarishi");
  const vitu_hatarishi_other = document.getElementById("vitu_hatarishi_other");

  if (vitu_hatarishi.checked && vitu_hatarishi.value === "96") {
    vitu_hatarishi_other.style.display = "block";
  } else {
    vitu_hatarishi_other.style.display = "none";
  }
});
