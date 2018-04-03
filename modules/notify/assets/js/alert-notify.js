$(document).ready(function () {
    $('button[data-dismiss]').on('click', function () {
        var $notifyAlert =$(this).parent('.notify-alert');
        if ($notifyAlert.length > 0) {
            var id = $notifyAlert.data('id');
            $.get('/notify/default/close-notify-alert?id=' + id);
        }
    });
});