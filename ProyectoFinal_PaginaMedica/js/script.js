function mostrarMensaje(enviar){

alert("La informacion se ha enviado correctamente");

}

// script.js
document.getElementById('appointmentForm').addEventListener('submit', function (event) {
    event.preventDefault();
    document.querySelector('.alert').style.display = 'block';
});


//funcion para correo y numero de teleno en citas
function isValidEmail(email) {
    // Patrón básico de validación de correo electrónico
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function isValidPhone(phone) {
    // Patrón básico de validación de número de teléfono
    var phoneRegex = /^\d{10}$/;
    return phoneRegex.test(phone);
}