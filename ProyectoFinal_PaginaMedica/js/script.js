function mostrarMensaje(enviar){

alert("La informacion se ha enviado correctamente");

}

// script.js
document.getElementById('appointmentForm').addEventListener('submit', function (event) {
    event.preventDefault();
    document.querySelector('.alert').style.display = 'block';
});


// Función para validar el correo electrónico
function isValidEmail(email) {
    // Utiliza una expresión regular para validar el formato del correo electrónico
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
  }
  
  // Función para validar el número de teléfono
  function isValidPhone(phone) {
    // Utiliza una expresión regular para permitir solo dígitos y espacios en blanco
    var phoneRegex = /^[0-9\s]+$/;
    return phoneRegex.test(phone);
  }
  
  // Agrega el evento de submit al formulario
  document.getElementById('appointmentForm').addEventListener('submit', function (event) {
    // Validación del nombre
    var fullName = document.getElementById('fullName').value;
    if (!fullName.trim()) {
      alert('Por favor, ingrese su nombre completo.');
      event.preventDefault();
      return;
    }
  
    // Validación del correo electrónico
    var email = document.getElementById('email').value;
    if (!isValidEmail(email)) {
      alert('Por favor, ingrese una dirección de correo electrónico válida.');
      event.preventDefault();
      return;
    }
  
    // Validación del número de teléfono
    var phone = document.getElementById('phone').value;
    if (!isValidPhone(phone)) {
      alert('Por favor, ingrese un número de teléfono válido.');
      event.preventDefault();
      return;
    }
  });
  

// Este script es para el llenado del fromulario que va hacia Procesar_cita.php que trabaja con citas.htmlo
document.getElementById('appointmentForm').addEventListener('submit', function (event) {
    // Validaciones ...

    // Obtener los datos del formulario
    var formData = new FormData(this);

    // Enviar los datos al servidor usando fetch
    fetch('procesar_cita.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        // Manejar la respuesta del servidor (puede ser un mensaje de éxito, error, etc.)
        console.log(data);
        // Mostrar mensaje de éxito en el formulario
        document.querySelector('.alert-success').style.display = 'block';
    })
    .catch(error => {
        // Manejar errores
        console.error('Error al enviar los datos:', error);
    });

    // Evitar que el formulario se envíe de la manera convencional
    event.preventDefault();
});
