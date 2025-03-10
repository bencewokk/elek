jQuery(document).ready(function($) {
    // Upload logo button
    $('.upload_logo_button').click(function(e) {
        e.preventDefault();

        var button = $(this);
        var custom_uploader = wp.media({
            title: 'Select Team Logo',
            button: { text: 'Use this logo' },
            multiple: false // Allow only one file to be selected
        }).on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            $('#team_logo_id').val(attachment.id); // Set the hidden input value
            $('#team_logo_preview').html('<img src="' + attachment.url + '" style="max-width:150px;display:block;margin-top:10px;">'); // Display the image
        }).open();
    });

    // Remove logo button
    $('.remove_logo_button').click(function(e) {
        e.preventDefault();
        $('#team_logo_id').val(''); // Clear the hidden input value
        $('#team_logo_preview').html(''); // Remove the image preview
    });
});