// Plugin de Creación Propia: Contador de Caracteres
// Este plugin añade un contador dinámico debajo del elemento seleccionado
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
