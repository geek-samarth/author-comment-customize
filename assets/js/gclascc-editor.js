(function($) {

    'use strict';
    var GCLacc = {};

    $(document).ready(function() {

        // Add Social Links
        $('.gclacc-add-social-link a').click(function(e) {

            e.preventDefault();

            if (undefined === GCLacc.html) {
                GCLacc.html = '<tr> <th><span class="gclacc-drag"></span><select name="gclacc-social-icons[]">';
                $.each(GCLACC_helper.socialIcons, function(key, name) {
                    GCLacc.html = GCLacc.html + '<option value="' + key + '">' + name + '</option>';
                });
                GCLacc.html = GCLacc.html + '</select></th><td><input name="gclacc-social-links[]" type="text" class="regular-text"><span class="dashicons dashicons-trash"></span><td></tr>';
            }

            $('#gclacc-social-table').append(GCLacc.html);

        });

        // Remove Social Link
        $('#gclacc-social-table').on('click', '.dashicons-trash', function() {
            var row = $(this).parents('tr');
            row.fadeOut('slow', function() {
                row.remove();
            });
        });

    });
})(jQuery);