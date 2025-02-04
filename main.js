// HERO
window.onload = function() {
    setTimeout(() => {
        const rightImage = document.querySelector('.right');
        const text = document.querySelector('.text-container');
  
        rightImage.classList.add('move-right'); // Mover la imagen derecha
        text.classList.add('reveal'); // Revelar el texto
    }, 2000); // Espera 2 segundos antes de ejecutar el movimiento
  
    displayDates();
    displayBrowserInfo();
  };
  
  // Función para obtener y mostrar la fecha del sistema
  function displayDates() {
      const currentDate = new Date();
      document.getElementById('currentDateHeader').textContent = `Fecha actual: ${currentDate.toLocaleDateString()}`;
      
      const lastModified = new Date(document.lastModified);
      document.getElementById('lastModifiedHeader').textContent = `Última modificación: ${lastModified.toLocaleDateString()}`;
  }
  
  // Función para obtener y mostrar el nombre del navegador y su versión
  function displayBrowserInfo() {
      const userAgent = navigator.userAgent;
      let browserName = "Desconocido";
      let fullVersion = "Desconocida";
      let temp;
  
      // Detectar navegador
      if ((temp = userAgent.match(/Opera|OPR\/(\d+(\.\d+)?)/))) {
          browserName = "Opera";
          fullVersion = temp[1];
      } else if ((temp = userAgent.match(/Edg\/(\d+(\.\d+)?)/))) {
          browserName = "Microsoft Edge";
          fullVersion = temp[1];
      } else if ((temp = userAgent.match(/Chrome\/(\d+(\.\d+)?)/))) {
          browserName = "Chrome";
          fullVersion = temp[1];
      } else if ((temp = userAgent.match(/Safari\/(\d+(\.\d+)?)/))) {
          browserName = "Safari";
          fullVersion = userAgent.match(/Version\/(\d+(\.\d+)?)/)[1];
      } else if ((temp = userAgent.match(/Firefox\/(\d+(\.\d+)?)/))) {
          browserName = "Firefox";
          fullVersion = temp[1];
      } else if ((temp = userAgent.match(/MSIE (\d+(\.\d+)?)/))) {
          browserName = "Internet Explorer";
          fullVersion = temp[1];
      }
  
      document.getElementById('browserInfo').textContent = `Navegador: ${browserName} ${fullVersion}`;
  }