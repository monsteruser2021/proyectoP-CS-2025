// HERO
window.onload = function() {
    setTimeout(() => {
        const rightImage = document.querySelector('.right');
        const text = document.querySelector('.text-container');
  
        rightImage.classList.add('move-right');
        text.classList.add('reveal');
    }, 2000);
  
    displayDates();
    displayBrowserInfo();
};

function displayDates() {
    const currentDate = new Date();
    document.getElementById('currentDateHeader').textContent = `Fecha actual: ${currentDate.toLocaleDateString()}`;
    
    fetch(document.URL, { method: 'HEAD' })
        .then(response => {
            const lastModified = new Date(response.headers.get('Last-Modified'));
            document.getElementById('lastModifiedHeader').textContent = `Última modificación: ${lastModified.toLocaleDateString()}`;
        })
        .catch(error => {
            console.error('Error obteniendo la fecha de la última modificación:', error);
        });
}

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