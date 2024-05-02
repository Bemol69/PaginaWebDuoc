

/* --- FORMULARIO SCRIPT */
const registrationForm = document.getElementById('registrationForm');
const registrationBtn = document.getElementById('registrationBtn');
const validationMessages = document.getElementById('validationMessages');

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
    } else if (name.length < 8) { // Verificar si el nombretiene menos de 8 caracteres
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
        // Redirigir a la página de confirmación
        window.location.href = 'Confirmado.html';
        alert('Correo enviado correctamente');
    } else {
        validationMessages.style.display = 'block';
    }
});



