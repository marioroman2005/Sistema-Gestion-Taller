// Plugin 1: Resaltado de Foco (resaltadoFoco)
(function ($) {
    $.fn.resaltadoFoco = function (opciones) {
        var config = $.extend({
            colorFoco: "#e3f2fd",
            colorError: "#ffcdd2",
            colorNormal: "#ffffff"
        }, opciones);

        return this.each(function () {
            var $input = $(this);

            $input.on("focus", function () {
                $(this).css("background-color", config.colorFoco);
            });

            $input.on("blur", function () {
                if ($(this).val().trim() === "") {

                    $(this).css("background-color", config.colorError);
                } else {
                    $(this).css("background-color", config.colorNormal);
                }
            });
        });
    };
})(jQuery);

// Plugin 2: Muestra la cantidad de caracteres escritos.
(function ($) {
    $.fn.contadorSimple = function () {
        return this.each(function () {
            var $input = $(this);
            var $span = $("<div class='contador-info' style='font-size: 0.8em; color: gray; margin-bottom: 10px; text-align: right;'></div>");

            $input.after($span);

            function actualizar() {
                var largo = $input.val().length;
                $span.text("Caracteres: " + largo);
            }


            $input.on("input keyup", actualizar);

            actualizar();
        });
    };
})(jQuery);

// Plugin 3: Contador de Caracteres (contarCaracteres)
(function ($) {
    $.fn.contarCaracteres = function (opciones) {
        // Configuración por defecto
        var configuracion = $.extend({
            color: "#666",
            texto: "Caracteres actuales: "
        }, opciones);

        return this.each(function () {
            var $input = $(this);
            var $contador = $('<div class="contador-chars" style="font-size: 0.9em; margin-top: 5px;"></div>');
            $contador.css("color", configuracion.color);

            // Insertar después del input/textarea
            $input.after($contador);

            function actualizar() {
                var longitud = $input.val().length;
                $contador.text(configuracion.texto + longitud);
            }

            $input.on('input', actualizar);
            actualizar();
        });
    };
})(jQuery);

// Plugin 4: Botón Limpiar (botonLimpiar)
(function ($) {
    $.fn.botonLimpiar = function () {
        return this.each(function () {
            var $input = $(this);

            var $wrapper = $("<div style='position: relative; margin-bottom: 20px;'></div>");
            $input.wrap($wrapper);

            var $btn = $("<span style='position: absolute; right: 10px; top: 12px; cursor: pointer; color: #999; font-weight: bold; display: none;'>✖</span>");
            $input.after($btn);

            function toggleBtn() {
                if ($input.val().length > 0) {
                    $btn.fadeIn(200);
                } else {
                    $btn.fadeOut(200);
                }
            }

            $btn.on("click", function () {
                $input.val("").trigger("input").focus();
                toggleBtn();
            });

            $input.on("input keyup", toggleBtn);

            toggleBtn();
        });
    };
})(jQuery);

// 1. FUNCIONES DE VALIDACIÓN (ONSUBMIT)

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

// 2. EVENTOS JAVASCRIPT NATIVO (DOM)

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

// 3. INICIALIZACIÓN DE PLUGINS (JQUERY)

if (typeof jQuery !== 'undefined') {
    $(document).ready(function () {

        // --- ACTIVACIÓN PLUGIN 1: Resaltado de Foco ---
        $("#dni, #nombre, #telefono, #email").resaltadoFoco({
            colorFoco: "#e8f0fe",
            colorError: "#ffebee"
        });

        // Activación Plugin 2: Contador Simple
        $("#nombre").contadorSimple();

    });
}