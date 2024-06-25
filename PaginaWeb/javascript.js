

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

document.addEventListener('DOMContentLoaded', () => {
  // Variables
  const baseDeDatos = [
    // ... (mismo código de producto)
  ];
  let carrito = [];
  const divisa = '$';
  const DOMitems = document.querySelector('#items');
  const DOMcarrito = document.querySelector('#cart-content');
  const DOMtotal = document.querySelector('#total');
  const DOMcartBtn = document.querySelector('#cart-btn');
  const DOMcartCount = document.querySelector('#cart-count');
  const DOMcartContainer = document.querySelector('#cart-container');

  // Funciones
  function renderizarProductos() {
    // ... (mismo código de renderización de productos)
  }

  function anyadirProductoAlCarrito(evento) {
    carrito.push(evento.target.getAttribute('marcador'));
    renderizarCarrito();
    actualizarContadorCarrito();
  }

  function renderizarCarrito() {
    // ... (mismo código de renderización del carrito)
  }

  function borrarItemCarrito(evento) {
    const id = evento.target.dataset.item;
    carrito = carrito.filter((carritoId) => {
      return carritoId !== id;
    });
    renderizarCarrito();
    actualizarContadorCarrito();
  }

  function calcularTotal() {
    // ... (mismo código de cálculo del total)
  }

  function actualizarContadorCarrito() {
    DOMcartCount.textContent = carrito.length;
  }

  function toggleCartContainer() {
    DOMcartContainer.style.display = DOMcartContainer.style.display === 'none' ? 'block' : 'none';
  }

  // Eventos
  DOMcartBtn.addEventListener('click', toggleCartContainer);

  // Inicio
  renderizarProductos();
});