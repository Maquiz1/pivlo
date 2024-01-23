for (let i = 1; i <= 100; i++) {
  const currently_smoking1 = `currently_smoking_${i}`;
  const packs1 = `packs_${i}`;
  const quit_smoking1 = `quit_smoking_${i}`;

  console.log(currently_smoking1);

  const currently_smoking = document.getElementById(currently_smoking1);
  const packs = document.getElementById(packs1);
  const quit_smoking = document.getElementById(quit_smoking1);

  function showElement() {
    if (currently_smoking.value === "1") {
      packs.style.display = "block";
      quit_smoking.style.display = "none";
    } else if (currently_smoking.value === "2") {
      packs.style.display = "none";
      quit_smoking.style.display = "block";
    } else {
      packs.style.display = "none";
      quit_smoking.style.display = "none";
    }

    // Save the selected value in localStorage
    localStorage.setItem("selectedValue", currently_smoking.value);
  }

  // Check if there's a previously selected value in localStorage
  const currently_smokingValue = localStorage.getItem("selectedValue");

  if (currently_smokingValue) {
    currently_smoking.value = currently_smokingValue;
  }

  // Show element if Option 2 is selected
  showElement();

  // Listen for changes in the dropdown
  currently_smoking.addEventListener("change", showElement);
}
