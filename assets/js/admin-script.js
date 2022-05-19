(function($) {
    'use strict';
    var gclacc = {};
    // Add Color Picker to all inputs that have 'color-field' class
    $(function() {
        $('.gclacc_colorpicker').wpColorPicker();
    });

    // Add Social Links
    $('.sabox-add-social-link a').click(function(e) {

        e.preventDefault();

        if (undefined === gclacc.html) {
            gclacc.html = '<tr> <th><span class="sabox-drag"></span><select name="sabox-social-icons[]">';
            $.each(SABHelper.socialIcons, function(key, name) {
                gclacc.html = gclacc.html + '<option value="' + key + '">' + name + '</option>';
            });
            gclacc.html = gclacc.html + '</select></th><td><input name="sabox-social-links[]" type="text" class="regular-text"><span class="dashicons dashicons-trash"></span><td></tr>';
        }

        $('#sabox-social-table').append(gclacc.html);

    });

    // Remove Social Link
    $('#sabox-social-table').on('click', '.dashicons-trash', function() {
        var row = $(this).parents('tr');
        row.fadeOut('slow', function() {
            row.remove();
        });
    });

    console.log("helo world");
})(jQuery);