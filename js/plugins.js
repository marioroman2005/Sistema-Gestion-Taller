// Plugin 1: Resaltado de Foco (resaltadoFoco)
// Cambia el color de fondo al recibir foco y valida si está vacío al salir (blur).
(function ($) {
    $.fn.resaltadoFoco = function (opciones) {
        var config = $.extend({
            colorFoco: "#e3f2fd",   // Azul claro por defecto
            colorError: "#ffcdd2", // Rojo claro por defecto
            colorNormal: "#ffffff" // Blanco
        }, opciones);

        return this.each(function () {
            var $input = $(this);

            $input.on("focus", function () {
                $(this).css("background-color", config.colorFoco);
            });

            $input.on("blur", function () {
                if ($(this).val().trim() === "") {
                    // Si está vacío, marcar en rojo
                    $(this).css("background-color", config.colorError);
                } else {
                    // Si tiene contenido, volver a normal
                    $(this).css("background-color", config.colorNormal);
                }
            });
        });
    };
})(jQuery);

// Plugin 2: Contador de Caracteres Simple (contadorSimple)
// Muestra la cantidad de caracteres escritos.
(function ($) {
    $.fn.contadorSimple = function () {
        return this.each(function () {
            var $input = $(this);
            var $span = $("<div class='contador-info' style='font-size: 0.8em; color: gray; margin-bottom: 10px; text-align: right;'></div>");

            // Insertar el contador inmediatamente después del input
            $input.after($span);

            // Función interna para actualizar
            function actualizar() {
                var largo = $input.val().length;
                $span.text("Caracteres: " + largo);
            }

            // Eventos
            $input.on("input keyup", actualizar);

            // Inicializar
            actualizar();
        });
    };
})(jQuery);

// Plugin 3: Contador de Caracteres (contarCaracteres)
// (Restaurado: Usado en Reparaciones para la descripción)
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
// Añade un pequeño botón "X" para borrar el contenido del campo rápidamente.
(function ($) {
    $.fn.botonLimpiar = function () {
        return this.each(function () {
            var $input = $(this);

            // Envolver el input en un contenedor relativo para posicionar el botón
            var $wrapper = $("<div style='position: relative; margin-bottom: 20px;'></div>");
            $input.wrap($wrapper);

            // Crear el botón X
            var $btn = $("<span style='position: absolute; right: 10px; top: 12px; cursor: pointer; color: #999; font-weight: bold; display: none;'>✖</span>");
            $input.after($btn);

            // Mostrar/Ocultar botón según el contenido
            function toggleBtn() {
                if ($input.val().length > 0) {
                    $btn.fadeIn(200);
                } else {
                    $btn.fadeOut(200);
                }
            }

            // Evento click en el botón
            $btn.on("click", function () {
                $input.val("").trigger("input").focus(); // Borrar, disparar eventos y devolver foco
                toggleBtn();
            });

            // Eventos del input
            $input.on("input keyup", toggleBtn);

            // Inicializar estado
            toggleBtn();
        });
    };
})(jQuery);
