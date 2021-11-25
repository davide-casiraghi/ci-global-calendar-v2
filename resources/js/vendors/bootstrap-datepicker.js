$(document).ready(function() {

    var today = new Date();

    // Single selection - Past and future allowed
    $('.datepicker.all input').datepicker({
        format: 'dd/mm/yyyy',
        daysOfWeekHighlighted: "6,0",
        weekStart: 1,
        todayHighlight: true,
    });

    // Single selection - Just for past dates
    $('.datepicker.past input').datepicker({
        format: 'dd/mm/yyyy',
        daysOfWeekHighlighted: "6,0",
        weekStart: 1,
        endDate : today,
        todayHighlight: true,
    });

    // Single selection -  Just for future dates
    $('.datepicker.future input').datepicker({
        format: 'dd/mm/yyyy',
        daysOfWeekHighlighted: "6,0",
        weekStart: 1,
        startDate: today,
        todayHighlight: true,
    });

    // Multiple date selection
    $('.datepickerMultiple input').datepicker({
        format: 'dd/mm/yyyy',
        daysOfWeekHighlighted: "6,0",
        weekStart: 1,
        todayHighlight: true,
        startDate: today,
        multidate: true,
        multidateSeparator: ","
    });

});