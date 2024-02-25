const currently_smoking1 = document.getElementById("currently_smoking1");
const currently_smoking2 = document.getElementById("currently_smoking2");

const quit_smoking = document.getElementById("quit_smoking");

function toggleElementVisibility() {
  if (currently_smoking1.checked) {
    quit_smoking.style.display = "none";
  } else if (currently_smoking2.checked) {
    quit_smoking.style.display = "block";
  } else {
    quit_smoking.style.display = "none";
  }
}

currently_smoking1.addEventListener("change", toggleElementVisibility);
currently_smoking2.addEventListener("change", toggleElementVisibility);

// Initial check
toggleElementVisibility();



function toggleRequiredCurrentlySmoking(radio) {
  var quit_smoking1_1 = document.getElementById("quit_smoking1");
  if (radio.value === "2") {
    quit_smoking1_1.setAttribute("required", "required");
  } else {
    quit_smoking1_1.removeAttribute("required");
    // if (quit_smoking1_1.value !== "") {
    //   quit_smoking1_1.value = "";
    // }
  }
}

