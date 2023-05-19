$(document).ready(function () {
    const action_url = BASE_URL_JS + 'actions/dashboard.php';
    function loadDataDashboard() {
        $('#loader').show();
        $.ajax({
            url: action_url,
            type: 'GET',
            data: {
                action: 'countTotal',
            },
            dataType: 'json',
            success: function (data) {
                $('#loader').hide();
                animateNumber('total-devices', data.total_devices);
                animateNumber('total-channels', data.total_channels);
            },
            error: function (xhr, status, error) {
                $('#loader').hide();
                showAlert(xhr.responseText, 'danger');
            }
        });
    }

    function animateNumber(elementId, targetNumber) {
        var element = $('#' + elementId);
        var currentNumber = parseInt(element.text());
        var duration = 1000; // Animation duration in milliseconds
        var interval = 50; // Interval between updates in milliseconds
        var steps = duration / interval;
        var increment = (targetNumber - currentNumber) / steps;
        var count = 0;

        var numberInterval = setInterval(function () {
            currentNumber += increment;
            element.text(Math.round(currentNumber));

            count++;
            if (count >= steps) {
                clearInterval(numberInterval);
                element.text(targetNumber);
            }
        }, interval);
    }
    loadDataDashboard();
});