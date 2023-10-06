// Import daterangepicker
import 'daterangepicker/daterangepicker.css';
import 'daterangepicker';
import moment from 'moment'; // Import moment.js

$(function () {
    function updateDateRangePicker(element, unavailableDates) {
        element.daterangepicker({
            opens: 'left',
            isInvalidDate: function (date) {
                var currentDate = moment();
                var formattedDate = date.format('YYYY-MM-DD');
                for (var i = 0; i < unavailableDates.length; i++) {
                    if (
                        // Si la date est à l'intérieur d'une plage de dates indisponibles
                        (formattedDate >= unavailableDates[i].start_date && formattedDate <= unavailableDates[i].end_date) ||
                        // Si la date est avant la date actuelle
                        date.isBefore(currentDate, 'day') ||
                        // Si la date est juste avant ou juste après une plage de dates indisponibles
                        formattedDate === moment(unavailableDates[i].start_date).subtract(1, 'days').format('YYYY-MM-DD') ||
                        formattedDate === moment(unavailableDates[i].end_date).add(1, 'days').format('YYYY-MM-DD')
                    ) {
                        return true;
                    }
                }
                
                return false;
            }
        }, function (start, end, label) {
            console.log("Une nouvelle sélection de date a été effectuée : " + start.format('YYYY-MM-DD') + ' à ' + end.format('YYYY-MM-DD'));

            // Copier la valeur du datetime dans tous les champs d'entrée avec name="hostingDate"
            $('input[name="hostingDate"]').val(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));

            var selectedDateRange = start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD');
           // Update the URL with the new value of the hostingDate query parameter
           var queryString = window.location.search;
           var urlParams = new URLSearchParams(queryString);
           urlParams.set('hostingDate', selectedDateRange);

           // Replace the current URL with the updated URL
           var newUrl = window.location.pathname + '?' + urlParams.toString();
           window.history.replaceState({}, '', newUrl);
        });
    }

    // Select all input elements whose IDs start with "daterange"
    $('input[id^="daterange"]').each(function () {
        var element = $(this);
        var hostingId = element.data('hosting-id'); // Get the hosting ID from a data attribute
        var matches = element[0].name.match(/\d+/); // Match one or more digits
        var hostingId = parseInt(matches[0], 10); // Convert the matched string to an integer
        console.log(hostingId); // This will output 31

        // Effectuer une requête AJAX pour obtenir les dates indisponibles avec start_date et end_date
        $.ajax({
            url: '/getUnavailableDate/' + hostingId, // Use the hosting ID in the URL
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                // Mettez à jour le date range picker avec les dates indisponibles récupérées
                updateDateRangePicker(element, data);
            },
            error: function (error) {
                console.error('Erreur lors de la récupération des dates indisponibles :', error);
            }
        });
    });
});