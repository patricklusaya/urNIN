$(document).ready(function() {
    // When the modal is triggered by clicking on the eye icon
    $('#viewModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var id = button.data('id'); // Extract the ID from data-id attribute
        var modal = $(this);

        // Send an AJAX request to fetch the search history details
        $.ajax({
            url: '/nida/scripts/fetch_history_details.php', // This file will handle the AJAX request
            method: 'POST',
            data: { nin: id }, // Send the extracted id as nin to match your PHP script
            success: function(response) {
                // Load the response (search history details) into the modal
                modal.find('#modalContent').html(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error loading history details: " + textStatus, errorThrown);
            }
        });
    });
});
