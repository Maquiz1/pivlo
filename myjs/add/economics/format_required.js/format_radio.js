const form = document.getElementById("myForm");

form.addEventListener("submit", function (event) {
  const questions = ["income_household", "income_patient"];
    //   const questions = ["question1", "question2", "question3"];
    
  let isValid = true;

  questions.forEach(function (question) {
    const radios = document.querySelectorAll('input[name="' + question + '"]');
    let checked = false;
    for (let i = 0; i < radios.length; i++) {
      if (radios[i].checked) {
        checked = true;
        break;
      }
    }
    if (!checked) {
      isValid = false;
      alert("Please select an option for " + question + ".");
    }
  });

  if (!isValid) {
    event.preventDefault();
  }
});
