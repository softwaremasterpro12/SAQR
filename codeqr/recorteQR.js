document.addEventListener("DOMContentLoaded", function() {
    const contenedor = document.querySelector(".contenedorQR");
    const formulario = document.getElementById("formulario");
    const recortarBtn = document.getElementById("recortarBtn");

    formulario.addEventListener("submit", async function(event) {
        event.preventDefault();
        // Aquí va el código para enviar los datos del formulario a la base de datos
        // ...
    });

    recortarBtn.addEventListener("click", function() {
        // Obtener la imagen del código QR
        const qrImage = document.querySelector(".contenedorQR img");
        if (qrImage) {
            // Convertir la imagen a una cadena base64
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d');
            canvas.width = qrImage.width;
            canvas.height = qrImage.height;
            ctx.drawImage(qrImage, 0, 0);
            const codigoQRBase64 = canvas.toDataURL('image/png');
            
            // Almacenar la imagen base64 en el campo oculto del formulario
            const codigoQRInput = document.getElementById("codigoQR");
            codigoQRInput.value = codigoQRBase64;
            
            // Enviar los datos del formulario al servidor
            const formData = new FormData(formulario);
            fetch('guardar_datos.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    return response.text();
                }
                throw new Error('Error al guardar los datos');
            })
            .then(responseData => {
                console.log(responseData);
                // Limpiar el formulario después de guardar los datos
                formulario.reset();
            })
            .catch(error => {
                console.error('Error:', error.message);
                // Manejar el error según sea necesario
            });
        } else {
            console.error('No se encontró ninguna imagen de código QR');
        }
    });
});
