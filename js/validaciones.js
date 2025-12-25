
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
