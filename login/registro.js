// Función para cambiar el color de fondo al enfocar
function handleFocus(event) {
  event.target.style.backgroundColor = '#e0e0e0';
}

// Función para restaurar el color de fondo al desenfocar
function handleBlur(event) {
  event.target.style.backgroundColor = '';
  if (event.target.tagName === 'INPUT' || event.target.tagName === 'TEXTAREA') {
      event.target.value = event.target.value.toUpperCase();
  }
}

// Función para manejar el evento de clic en el botón de enviar
function handleSubmit() {
  const username = document.getElementById('username').value;
  const fullname = document.getElementById('fullname').value;
  alert(`Nombre de usuario: ${username}\nNombre completo: ${fullname}`);
}

// Agregar los eventos a los elementos del formulario
document.addEventListener('DOMContentLoaded', () => {
  const inputs = document.querySelectorAll('input[type="text"], input[type="password"], input[type="email"], textarea');

  inputs.forEach(input => {
      input.addEventListener('focus', handleFocus);
      input.addEventListener('blur', handleBlur);
  });

  const submitBtn = document.getElementById('submitBtn');
  submitBtn.addEventListener('click', handleSubmit);
});