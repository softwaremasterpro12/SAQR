document.getElementById('generarQRBtn').addEventListener('click', function() {
    const item = document.getElementById('item').value;
    const insumo = document.getElementById('insumo').value;
    const cantidad = document.getElementById('cantidad').value;
    const valorUnidad = document.getElementById('valorUnidad').value;

    // Generar el valor total
    document.getElementById('valorTotal').value = cantidad * valorUnidad;

    // Crear el contenido del QR
    const qrContent = `Item: ${item}, Insumo: ${insumo}, Cantidad: ${cantidad}, Valor Unidad: ${valorUnidad}, Valor Total: ${cantidad * valorUnidad}`;

    // Generar el código QR
    const qrContainer = document.getElementById('contenedorQR');
    qrContainer.innerHTML = '';
    new QRCode(qrContainer, {
        text: qrContent,
        width: 128,
        height: 128
    });
});

document.getElementById('formulario').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevenir el envío del formulario tradicional

    const item = document.getElementById('item').value;
    const insumo = document.getElementById('insumo').value;
    const cantidad = document.getElementById('cantidad').value;
    const valorUnidad = document.getElementById('valorUnidad').value;
    const valorTotal = document.getElementById('valorTotal').value;
    const qrCanvas = document.querySelector('#contenedorQR canvas');
    
    if (!qrCanvas) {
        alert('Primero genera el código QR.');
        return;
    }
    
    const codigoQR = qrCanvas.toDataURL(); // Obtener el código QR en base64

    // Enviar los datos al servidor
    fetch('guardar_datos.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            item: item,
            insumo: insumo,
            cantidad: cantidad,
            valorUnidad: valorUnidad,
            valorTotal: valorTotal,
            codigoQR: codigoQR
        })
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
