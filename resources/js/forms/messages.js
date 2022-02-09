$(document).ready(function () {
    // Show the contextual message after a message is sent using Livewire components.
    Livewire.on('livewireContextualFeedback', data => {
        $('.livewireEmitMessages').append(data.message);
        $(".livewireEmitMessages").addClass(data.status); //'danger', 'warning', 'success'
        $('.livewireEmitMessages').removeClass("hidden");
        document.body.scrollTop = document.documentElement.scrollTop = 0;
    });
});