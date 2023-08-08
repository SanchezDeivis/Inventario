// Obtener elementos de la página
const imagenesProductos = document.querySelectorAll('.imagen-producto');
const dialogOverlay = document.getElementById('dialog-overlay');
const dialogImage = document.getElementById('dialog-image');

// Agregar evento clic a cada imagen de producto
imagenesProductos.forEach(imagen => {
    imagen.addEventListener('click', function () {
        const imagenSrc = imagen.getAttribute('src');
        dialogImage.src = imagenSrc;
        dialogOverlay.style.display = 'flex';
    });
});

// Cerrar el diálogo al hacer clic fuera de la imagen
dialogOverlay.addEventListener('click', function (event) {
    if (event.target === dialogOverlay) {
        dialogOverlay.style.display = 'none';
    }
});
