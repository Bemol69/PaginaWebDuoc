/* --- FORMULARIO SCRIPT */
const registrationForm = document.getElementById('registrationForm');
const registrationBtn = document.getElementById('registrationBtn');
const validationMessages = document.getElementById('validationMessages');

// Función para guardar los datos de registro en localStorage
function saveRegistrationData(email, password) {
  localStorage.setItem('registeredEmail', email);
  localStorage.setItem('registeredPassword', password);
}

// Función para verificar las credenciales de inicio de sesión
function verifyLoginCredentials(email, password) {
  const registeredEmail = localStorage.getItem('registeredEmail');
  const registeredPassword = localStorage.getItem('registeredPassword');

  if (email === registeredEmail && password === registeredPassword) {
    // Credenciales válidas, redirigir a index.html
    window.location.href = 'index.html';
  } else {
    // Credenciales inválidas, mostrar mensaje de error
    alert('Las credenciales ingresadas son incorrectas o no estas registrado. Por favor, inténtalo nuevamente.');
  }
}

registrationBtn.addEventListener('click', function(event) {
  event.preventDefault();
  const name = document.getElementById('form2Example11').value.trim();
  const email = document.getElementById('form2Example12').value.trim();
  const password = document.getElementById('form2Example22').value.trim();
  let isValid = true;
  validationMessages.style.display = 'none';
  validationMessages.innerHTML = '';

  // Validar nombre
  if (name === '') {
    isValid = false;
    validationMessages.innerHTML += '<p>Por favor, ingresa tu nombre.</p>';
  } else if (name.length < 8) { // Verificar si el nombre tiene menos de 8 caracteres
    isValid = false;
    validationMessages.innerHTML += '<p>El nombre debe tener al menos 8 caracteres.</p>';
  }

  // Validar correo electrónico
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (email === '' || !emailRegex.test(email)) {
    isValid = false;
    validationMessages.innerHTML += '<p>Por favor, ingresa un correo electrónico válido de Gmail.</p>';
  }

  // Validar contraseña
  if (password === '') {
    isValid = false;
    validationMessages.innerHTML += '<p>Por favor, ingresa una contraseña.</p>';
  } else if (password.length < 8) { // Verificar si la contraseña tiene menos de 8 caracteres
    isValid = false;
    validationMessages.innerHTML += '<p>La contraseña debe tener al menos 8 caracteres.</p>';
  }

  if (isValid) {
    // Guardar los datos de registro en localStorage
    saveRegistrationData(email, password);

    // Redirigir a la página de confirmación
    window.location.href = 'ingreso.html';
    alert('Correo enviado correctamente');
  } else {
    validationMessages.style.display = 'block';
  }
});