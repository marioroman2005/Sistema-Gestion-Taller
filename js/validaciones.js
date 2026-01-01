
function confirmarBorrado() {
    return confirm('¿Estás seguro de eliminar esta reparación?');
}

function validarReparacion() {

    let descripcion = document.getElementById('descripcion').value.trim();
    let fecha = document.getElementById('fecha').value.trim();
    let vehiculoSelect = document.getElementById('id_vehiculo');
    let precio = document.getElementById('precio').value.trim();

    if (descripcion.length === 0) {
        alert('La descripción no puede estar vacía.');
        return false;
    }
    if (fecha.length === 0) {
        alert('La fecha no puede estar vacía.');
        return false;
    }
    // Verificar si existe el select
    if (vehiculoSelect && vehiculoSelect.value === "") {
        alert('Debes seleccionar un vehículo.');
        return false;
    }

    if (precio.length === 0 || isNaN(precio) || parseFloat(precio) < 0) {
        alert('El precio debe ser un número válido y no puede ser negativo.');
        return false;
    }
    return true;
}

document.addEventListener("DOMContentLoaded", function () {

    // Evento para validar Matrícula en tiempo real
    const inputMatricula = document.getElementById("matricula");
    if (inputMatricula) {
        inputMatricula.addEventListener("keyup", function () {
            const valor = this.value;
            const regex = /^[0-9]{4}[A-Za-z]{3}$/;

            if (regex.test(valor)) {
                this.style.border = "2px solid green";
                this.style.backgroundColor = "#e8f0fe";
                this.style.outline = "none";
                this.style.boxShadow = "0 0 5px green";
            } else {
                this.style.border = "2px solid red";
                this.style.backgroundColor = "#ffe6e6";
                this.style.outline = "none";
                this.style.boxShadow = "0 0 5px red";
            }
        });
    }

    // Evento para convertir Marca y Modelo a Mayúsculas automáticamente
    const inputsTexto = ["marca", "modelo"];
    inputsTexto.forEach(function (id) {
        const input = document.getElementById(id);
        if (input) {
            input.addEventListener("blur", function () {
                this.value = this.value.toUpperCase();
                this.style.backgroundColor = "";
            });

            input.addEventListener("focus", function () {
                this.style.backgroundColor = "#fffde7";
            });
        }
    });

});
