const ever_smoked = document.getElementById("ever_smoked");
const ever_smoked1 = document.getElementById("ever_smoked1");
const ever_smoked2 = document.getElementById("ever_smoked2");
const ever_smoked3 = document.getElementById("ever_smoked3");

// console.log(type_smoked);

function showElement() {
  if (ever_smoked.value === "1") {
    ever_smoked1.style.display = "block";
    ever_smoked2.style.display = "block";
    ever_smoked3.style.display = "block";
  } else if (ever_smoked.value === "2") {
    ever_smoked1.style.display = "none";
    ever_smoked2.style.display = "none";
    ever_smoked3.style.display = "none";
  } else {
    ever_smoked1.style.display = "none";
    ever_smoked2.style.display = "none";
    ever_smoked3.style.display = "none";
  }

  // Save the selected value in localStorage
  localStorage.setItem("selectedValue", ever_smoked.value);
}

// Check if there's a previously selected value in localStorage
const ever_smokedValue = localStorage.getItem("selectedValue");

if (ever_smokedValue) {
  ever_smoked.value = ever_smokedValue;
}

// Show element if Option 2 is selected
showElement();

// Listen for changes in the dropdown
ever_smoked.addEventListener("change", showElement);





// $(function () {
//   $("#detailssame").click(function () {
//     var checked = $(this).is(":checked");
//     if (checked) {
//       $("#detailssamehide").hide();
//     } else {
//       $("#detailssamehide").show();
//     }
//     $(".fullboxform input[type=text], .fullboxform select").each(function () {
//       $(this).prop("required", !checked);
//     });
//   });
// });
