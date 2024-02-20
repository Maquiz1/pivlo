const relation_patient = document.getElementById("relation_patient96");
const relation_patient_other = document.getElementById(
  "relation_patient_other"
);

relation_patient.addEventListener("change", function () {
  if (this.checked) {
    relation_patient_other.style.display = "block";
  } else {
    relation_patient_other.style.display = "none";
  }
});

// Initial check
if (relation_patient.checked) {
  relation_patient_other.style.display = "block";
} else {
  relation_patient_other.style.display = "none";
}



