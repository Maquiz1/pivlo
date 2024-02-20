const form = document.getElementById("myForm");

form.addEventListener("submit", function (event) {
  const hiddenField = document.getElementById("hiddenField");
  if (!hiddenField || !hiddenField.value) {
    alert("Hidden field is empty.");
    event.preventDefault();
  }
});
