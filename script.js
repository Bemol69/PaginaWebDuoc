document.getElementById('registrationForm').addEventListener('submit', function(e) {
  e.preventDefault();

  const formData = new FormData(this);

  fetch('process.php', {
      method: 'POST',
      body: formData
  })
  .then(response => response.text())
  .then(data => {
      alert(data);
      document.getElementById('registrationForm').reset();
      window.location.href = 'ingreso.html';
  })
  .catch(error => console.error('Error:', error));
});