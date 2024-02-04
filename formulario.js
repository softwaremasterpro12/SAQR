// Validación de la contraseña
function validarContrasenas() {
    var contrasena = document.getElementById("contrasena").value;
    var repetir_contrasena = document.getElementById("repetir_contrasena").value;
  
    if (contrasena !== repetir_contrasena) {
      alert("Las contraseñas no coinciden.");
      return false;
    }
  
    return true;
  }
  
  // Asociamos la función de validación al evento submit del formulario
  document.getElementById("formulario").addEventListener("submit", validarContrasenas);
  