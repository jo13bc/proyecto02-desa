const format = {
    days: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
    daysShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
    daysMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá', 'Do'],
    months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
    today: "Hoy",
    clear: "Limpiar",
    format: 'dd/mm/yyyy',
    titleFormat: 'MM yyyy',
    weekStart: 0
};

window.onload = function() {
    main();
};

function main() {

    $.fn.datepicker.dates['en'] = format;
    $('.dp-date').each(function(i) {
        $(this).datepicker({
            format: 'dd-mm-yyyy'
        });
    });
    $('.dp-time').each(function(i) {
        $(this).datepicker({
            format: 'hh:ii'
        });
    });
}