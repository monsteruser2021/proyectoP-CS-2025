//HERO

window.onload = function() {
  setTimeout(() => {
      const rightImage = document.querySelector('.right');
      const text = document.querySelector('.text-container');

      rightImage.classList.add('move-right'); // Mover la imagen derecha
      text.classList.add('reveal'); // Revelar el texto
  }, 2000); // Espera 2 segundos antes de ejecutar el movimiento
};