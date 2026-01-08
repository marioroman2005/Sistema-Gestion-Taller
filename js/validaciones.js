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


function confirmarBorrado() {
    return confirm('¿Estás seguro de eliminar este registro?');
}

function validarReparacion() {
    let descripcion = document.getElementById('descripcion').value.trim();
    let fecha = document.getElementById('fecha').value.trim();
    if (descripcion.length === 0) return false;
    if (fecha.length === 0) return false;
    return true;
}

function validarCliente() {
    let dni = document.getElementById('dni').value.trim();
    let nombre = document.getElementById('nombre').value.trim();
    let telefono = document.getElementById('telefono').value.trim();

    if (dni.length === 0) {
        alert('El DNI es obligatorio.');
        return false;
    }
    if (nombre.length === 0) {
        alert('El nombre es obligatorio.');
        return false;
    }
    if (telefono.length < 9) {
        alert('El teléfono debe tener al menos 9 dígitos.');
        return false;
    }
    return true;
}


document.addEventListener("DOMContentLoaded", function () {

    // --- EVENTO JS 1: Capitalizar Nombre (Blur) ---
    // Convierte "juan perez" en "Juan Perez" al salir del campo
    const inputNombre = document.getElementById("nombre");
    if (inputNombre) {
        inputNombre.addEventListener("blur", function () {
            this.value = this.value.toLowerCase().replace(/(?:^|\s)\S/g, function (a) {
                return a.toUpperCase();
            });
        });
    }

    // --- EVENTO JS 2: Restricción Numérica Teléfono (Input) ---
    const inputTelefono = document.getElementById("telefono");
    if (inputTelefono) {
        inputTelefono.addEventListener("input", function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }

});

// ==========================================
// 3. INICIALIZACIÓN DE PLUGINS (JQUERY)
// ==========================================

if (typeof jQuery !== 'undefined') {
    $(document).ready(function () {

        // --- ACTIVACIÓN PLUGIN 1: Resaltado de Foco ---
        $("#dni, #nombre, #telefono, #email").resaltadoFoco({
            colorFoco: "#e8f0fe", // Azulito Google
            colorError: "#ffebee" // Rojito suave
        });

        // --- ACTIVACIÓN PLUGIN 2: Contador Simple ---
        $("#nombre").contadorSimple();

    });
}