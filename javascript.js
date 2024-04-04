// Función para agregar productos al carrito
const cartList = document.getElementById('cartList');

document.querySelectorAll('.btn-primary').forEach(function(button) {
  button.addEventListener('click', function() {
    const product = this.closest('.card').querySelector('.card-title').textContent;
    const listItem = document.createElement('li');
    listItem.classList.add('list-group-item');
    listItem.textContent = product;
    const removeButton = document.createElement('button');
    removeButton.classList.add('btn', 'btn-danger', 'btn-sm');
    removeButton.textContent = 'Eliminar';
    removeButton.addEventListener('click', function() {
      listItem.remove();
    });
    listItem.appendChild(removeButton);
    cartList.appendChild(listItem);
  });
});

// Función para enviar el formulario de pedido
const orderForm = document.getElementById('orderForm');

orderForm.addEventListener('submit', function(event) {
  event.preventDefault();
  const name = document.getElementById('name').value;
  const email = document.getElementById('email').value;
  const address = document.getElementById('address').value;
  alert(`¡Gracias por tu pedido, ${name}! Tu orden será enviada a ${address}.`);
  orderForm.reset();
});