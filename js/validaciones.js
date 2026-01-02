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

// --- NUEVA FUNCION: Validar Formulario de Clientes ---
function validarCliente() {
    let dni = document.getElementById('dni').value.trim();
    let nombre = document.getElementById('nombre').value.trim();
    let telefono = document.getElementById('telefono').value.trim();
    let email = document.getElementById('email').value.trim();

    if (dni.length === 0) {
        alert('El DNI es obligatorio.');
        return false;
    }
    if (dni.length < 8) {
         alert('El DNI no parece válido (muy corto).');
         return false;
    }

    if (nombre.length === 0) {
        alert('El nombre es obligatorio.');
        return false;
    }

    if (telefono.length === 0 || isNaN(telefono) || telefono.length < 9) {
        alert('El teléfono debe ser numérico y tener al menos 9 dígitos.');
        return false;
    }

    if (email.length > 0 && !email.includes('@')) {
        alert('El formato del email no es correcto.');
        return false;
    }

    return true;
}

document.addEventListener("DOMContentLoaded", function () {

    // Evento para validar Matrícula en tiempo real (Reparaciones)
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

    // Evento para convertir Marca y Modelo a Mayúsculas (Reparaciones)
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

    // --- NUEVO EVENTO JS 1: Capitalizar Nombre automáticamente (Blur) ---
    const inputNombreCliente = document.getElementById("nombre");
    if (inputNombreCliente) {
        inputNombreCliente.addEventListener("blur", function () {
            this.value = this.value.toLowerCase().replace(/(?:^|\s)\S/g, function(a) { 
                return a.toUpperCase(); 
            });
        });
    }

    // --- NUEVO EVENTO JS 2: Restringir Teléfono solo a números (Input) ---
    const inputTelefono = document.getElementById("telefono");
    if (inputTelefono) {
        inputTelefono.addEventListener("input", function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }

});

// --- Integración de Plugins jQuery (al final) ---
if (typeof jQuery !== 'undefined') {
    $(function() {
        // Plugin 1: Resaltado de Foco para campos de Clientes
        $("#dni, #nombre, #telefono, #email").resaltadoFoco({
            colorFoco: "#e8f0fe",
            colorError: "#ffebee"
        });

        // Plugin 2: Contador Simple para el Nombre del Cliente
        $("#nombre").contadorSimple();
    });
}