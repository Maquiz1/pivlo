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
