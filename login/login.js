// Función para cambiar el color de fondo al enfocar
function handleFocus(event) {
  event.target.style.backgroundColor = '#e0e0e0';
}

// Función para restaurar el color de fondo al desenfocar
function handleBlur(event) {
  event.target.style.backgroundColor = '';
  if (event.target.tagName === 'INPUT') {
      event.target.value = event.target.value.toUpperCase();
  }
}

// Función para manejar el evento de clic en el botón de iniciar sesión
function handleLogin() {
  const username = document.getElementById('username').value;
  const password = document.getElementById('password').value;
  alert(`Nombre de usuario: ${username}\nContraseña: ${password}`);
}

// Agregar los eventos a los elementos del formulario
document.addEventListener('DOMContentLoaded', () => {
  const inputs = document.querySelectorAll('input[type="text"], input[type="password"]');

  inputs.forEach(input => {
      input.addEventListener('focus', handleFocus);
      input.addEventListener('blur', handleBlur);
  });

  const loginBtn = document.querySelector('.btn a');
  loginBtn.addEventListener('click', (event) => {
      event.preventDefault();
      handleLogin();
  });
});