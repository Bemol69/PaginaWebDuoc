document.addEventListener('DOMContentLoaded', function() {
  const form = document.querySelector('form');
  if (form) {
      form.addEventListener('submit', function(e) {
          e.preventDefault();

          const formData = new FormData(this);
          const isLoginForm = this.id === 'loginForm';
          const url = isLoginForm ? 'login.php' : 'process.php';

          fetch(url, {
              method: 'POST',
              body: formData
          })
          .then(response => response.text())
          .then(data => {
              if (isLoginForm) {
                  if (data === "success") {
                      alert("Inicio de sesión exitoso");
                      window.location.href = 'index.html';
                  } else {
                      alert(data);
                  }
              } else {
                  alert(data);
                  if (data === "Registro exitoso") {
                      window.location.href = 'inicio.html';
                  }
              }
              form.reset();
          })
          .catch(error => console.error('Error:', error));
      });
  }
});
