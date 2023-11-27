//Calcular Edad
function calculateAge(idBirthday, idAge) {
  // Obtener el valor del input date
  let birthDate = $("#" + idBirthday).val();
  // Convertirlo en un objeto Date
  let birthDateObj = new Date(birthDate);
  // Obtener la fecha actual
  let currentDate = new Date();
  // Calcular la diferencia en años
  let age = currentDate.getFullYear() - birthDateObj.getFullYear();
  // Ajustar por meses y días
  let monthDiff = currentDate.getMonth() - birthDateObj.getMonth();
  if (
    monthDiff < 0 ||
    (monthDiff === 0 && currentDate.getDate() < birthDateObj.getDate())
  ) {
    age--;
  }
  // Mostrar la edad en el input text
  $("#" + idAge).val(age);
}

//Calcular años abae
function calculateTime(idBirthday, idAge) {
  // Obtener el valor del input date
  let birthDate = $("#" + idBirthday).val();
  // Convertirlo en un objeto Date
  let birthDateObj = new Date(birthDate);
  // Obtener la fecha actual
  let currentDate = new Date();
  // Calcular la diferencia en años
  let age = currentDate.getFullYear() - birthDateObj.getFullYear();
  // Ajustar por meses y días
  let monthDiff = currentDate.getMonth() - birthDateObj.getMonth();
  if (
    monthDiff < 0 ||
    (monthDiff === 0 && currentDate.getDate() < birthDateObj.getDate())
  ) {
    age--;
  }
  // Mostrar la edad en el input text
  $("#" + idAge).val(age);
}

//Ocultar informacion de Casados / Conyugues
function hideMarriedInformation() {
  let statusInput = $("#status");
  let spouseDiv = $("#divSpouse");
  let spouseInput = $("#spouse");

  if (
    statusInput.val() == "Soltero(a)" ||
    statusInput.val() == "Viudo(a)" ||
    statusInput.val() == "Separado de Union Legal" ||
    statusInput.val() == "Separado de Union de Hecho"
  ) {
    spouseInput.val("N/A");
    spouseDiv.css("visibility", "hidden");
  } else {
    spouseInput.val("");
    spouseDiv.css("visibility", "visible");
  }
}

//Ocultar informacion femenina
function womanInformation() {
  let genderInput = $("#gender");
  let pregnantDiv = $("#divPregnant");
  let gestationDiv = $("#divGestation");
  let pregnant = $("#pregnant");
  let gestation = $("#gestation");

  if (genderInput.val() == "Masculino") {
    gestation.val("N/A");
    pregnant.val("N/A");
    gestationDiv.css("visibility", "hidden");
    pregnantDiv.css("visibility", "hidden");
  } else {
    gestation.val("");
    gestationDiv.css("visibility", "visible");
    pregnantDiv.css("visibility", "visible");
  }
}

//Ocultar informacion de Embarazo
function hideGestation() {
  let pregnantSelect = $("#pregnant");
  let gestationSelect = $("#gestation");
  let gestationDiv = $("#divGestation");

  if (pregnantSelect.val() == "No") {
    gestationSelect.val("N/A");
    gestationDiv.css("visibility", "hidden");
  } else {
    gestationDiv.css("visibility", "visible");
  }
}

//Ocultar enfermedades cronicas
function chronicFunction() {
  let chronicSelect = document.getElementById("chronicDisease");
  let chronicInput = document.getElementById("chronicInput");
  let chronicDiv = document.getElementById("chronicDiv");

  if (chronicSelect.value == "No") {
    chronicInput.value = "N/A";
    $('#chronicDiv').hide();
  } else {
    chronicInput.value = "";
    $('#chronicDiv').show();
  }
}
