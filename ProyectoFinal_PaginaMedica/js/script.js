function mostrarMensaje(enviar){

alert("La informacion se ha enviado correctamente");

}

// script.js
document.getElementById('appointmentForm').addEventListener('submit', function (event) {
    event.preventDefault();
    document.querySelector('.alert').style.display = 'block';
});