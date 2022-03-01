$(document).ready(function () {

    // ON LOAD
    if(($("#createEvent").length) || ($("#editEvent").length )){

        // SET the week days saved - when the edit view is open.
        var weekDaysSelected = $('#repeat_weekly_on').val();
        if (weekDaysSelected){
            var weekDaysSelectedArray = weekDaysSelected.split(',');
            for (i = 0; i < weekDaysSelectedArray.length; ++i) {
                //$('#onWeekly label input#day_'+ weekDaysSelectedArray[i]).addClass('active');
                $('#onWeekly label input#day_'+ weekDaysSelectedArray[i] ).attr('checked', true);
            }
        }

        // SET the repeat values, show and hide the repeat options - when the edit view is open.
        setRepeatValues();

        // ON CHANGE

        // SET the repeat values, show and hide the repeat options - when repeat type is changed.
        $("input[name='repeat_type']").change(function(){
            setRepeatValues();
        });

        // Every time the start date is changed - force same date start if repetitive, and UPDATE monthly select options.
        $("input[name='startDate']").change(function(){
            updateMonthlySelectOptions();
            setRepeatValues();
        });
    }

    /**************************************************************************************/

    // Show and hide the repeat options
    function setRepeatValues(radioVal) {
        var radioVal = $("input[name='repeat_type']:checked").val();
        switch(radioVal) {
            case '1':  // No Repeat
                $('.repeatDetails').hide();
                $('.repeatUntilSelector').hide();
                recreateDateEnd();
                break;
            case '2':  // Repeat Weekly
                $('.repeatDetails').show();
                $('.onFrequency').hide();
                $('#onWeekly').show();
                $('.repeatUntilSelector').show();
                forceSameDateStartEnd();
                break;
            case '3':  // Repeat Monthly
                $('.repeatDetails').show();
                $('.onFrequency').hide();
                $('#onMonthly').show();
                $('.repeatUntilSelector').show();
                forceSameDateStartEnd();
                updateMonthlySelectOptions();
                break;
            case '4':  // Repeat Multiple
                $('.repeatDetails').show();
                $('.onFrequency').hide();
                $('#onMultiple').show();
                $('.repeatUntilSelector').hide();
                forceSameDateStartEnd();
                break;
        }
    }

    // Force the same date start and end (this is to avoid mistakes of the users that set date end to the end of repetition).
    function forceSameDateStartEnd(){
        var dateStart = $("input[name='startDate']").val();
        var endDateFlatPicker = flatpickr("input[name='endDate']", {
            dateFormat: 'd/m/Y',
            locale: {
                firstDayOfWeek: 1,
            }
        });
        endDateFlatPicker.setDate(dateStart, false, "d/m/Y");
    }

    // Re-create the datepicker_end_date that has been destroyed in case of repetition.
    function recreateDateEnd(){
        var today = new Date();
        $("input[name='endDate']").flatpickr({
            dateFormat: 'd/m/Y',
            enableTime: false,
            minuteIncrement: 15,
            minDate: "today",
            maxDate: new Date().fp_incr(365), // 365 days from now
            locale: {
                firstDayOfWeek: 1,
            }
        });
    }

    // POPULATE the select "Monthly on" options - when the edit view is open.
    function updateMonthlySelectOptions(){

        var monthlyOnSelected = $("input[name='on_monthly_kind_value']").val();

        var request = $.ajax({
            url: "/event/monthSelectOptions",
            data: {
                day: $("input[name='startDate']").val()
            },
            success: function( data ) {
                $("#on_monthly_kind").html(data);
            }
        });

    }

});