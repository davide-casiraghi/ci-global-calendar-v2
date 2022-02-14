$(document).ready(function () {

    /**
     * Add Select2 single selection to all the divs with class .select2
     */
    $(".select2").select2({
        placeholder: "Select one",
        width: '100%'
    });

    /**
     * Add Select2 multiple selection to all the divs with class .select2-multiple
     */
    $(".select2-multiple").select2({
        placeholder: "Select one or more",
        width: '100%',
    });

});

/**
 * Set focus to search text field when we click on select2 dropdown.
 */
$(document).on('select2:open', (e) => {
    const selectId = e.target.id;
    $(".select2-search__field[aria-controls='select2-" + selectId + "-results']").each(function (
        key,
        value,
    ){
        value.focus();
    })
});