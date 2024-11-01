jQuery(document).ready(function () {



    jQuery('.aip_color_settings').colorPicker({
        renderCallback: function ($elm, toggled) {
            if (toggled === false) {
                var name = jQuery($elm).attr('name');
                var value = $elm.val();
                jQuery('#' + name + '_hidden').val(value);
                load_shortcode_values();
            }
        }


    });

    jQuery('.aip_settings_wrapper').matchHeight({property: 'min-height'});

    jQuery('input[class="aip_square"][type="radio"]').on('ifChecked', function (event) {
        var name = jQuery(this).attr('name');
        var value = jQuery('input[class="aip_square"][type="radio"][name="' + name + '"]:checked').val()
        jQuery('#' + name + '_hidden').val(value);
        load_shortcode_values();
    });
    jQuery('input[class="aip_square"][type="radio"]').iCheck({
        checkboxClass: 'icheckbox_square-purple',
        radioClass: 'iradio_square-purple'
    });
    jQuery('.aip_settings_tabs').pwstabs({
        tabsPosition: 'horizontal',
        verticalPosition: 'left',
        effect: 'slideleft'
    });





    jQuery('input[type="number"]').bindWithDelay('input', function () {
        var id = jQuery(this).attr('id');
        var value = jQuery(this).val();
        jQuery('#' + id + '_hidden').val(value);
        load_shortcode_values();
    }, 1500);
    load_shortcode_values();

    /* show/hide settings elements */

    jQuery('input[name="aip_support_lp"]').on('ifChecked', function (event) {
        if (jQuery('input[name="aip_support_lp"]:checked').val() == 'false') {
            jQuery('.aip_settings_tabs_support_false').slideDown();
            jQuery('.aip_settings_tabs_support_true').slideUp();
        } else {
            jQuery('.aip_settings_tabs_support_true').slideDown();
            jQuery('.aip_settings_tabs_support_false').slideUp();
        }
    });

    jQuery('input[name="aip_mode"]').on('ifChecked', function (event) {
        if (jQuery('input[name="aip_mode"]:checked').val() == 'slider') {
            jQuery('.aip_settings_tabs_mode_slider').slideDown();
            jQuery('.aip_settings_tabs_mode_wall_slider').slideDown();
            jQuery('.aip_settings_tabs_mode_wall').slideUp();
            jQuery('.aip_settings_tabs_mode_wallj').slideUp();
            jQuery('.aip_settings_tabs_mode_wall_margin').slideUp();

        } else if (jQuery('input[name="aip_mode"]:checked').val() == 'wall') {
            jQuery('.aip_settings_tabs_mode_slider').slideUp();
            jQuery('.aip_settings_tabs_mode_wall').slideDown();
            jQuery('.aip_settings_tabs_mode_wallj').slideUp();
            jQuery('.aip_settings_tabs_mode_wall_margin').slideDown();
        } else if (jQuery('input[name="aip_mode"]:checked').val() == 'wallj') {
            jQuery('.aip_settings_tabs_mode_slider').slideUp();
            jQuery('.aip_settings_tabs_mode_wall_slider').slideUp();
            jQuery('.aip_settings_tabs_mode_wall').slideUp();
            jQuery('.aip_settings_tabs_mode_wallj').slideDown();
            jQuery('.aip_settings_tabs_mode_wall_margin').slideDown();
        }
    });



});
function load_shortcode_values() {

    var aip_support_lp = jQuery('#aip_support_lp_hidden').val();
    var aip_mode = jQuery('#aip_mode_hidden').val();
    var aip_slider_number_of_cols = jQuery('#aip_slider_number_of_cols_hidden').val();
    var aip_slider_number_of_rows = jQuery('#aip_slider_number_of_rows_hidden').val();
    var aip_slider_height = jQuery('#aip_slider_height_hidden').val();
    var aip_wall_number_of_cols = jQuery('#aip_wall_number_of_cols_hidden').val();
    var aip_wallj_height = jQuery('#aip_wallj_height_hidden').val();

    var aip_shortcode = '[aip_shortcode ' +
            'aip_support_lp = "' + aip_support_lp + '" ' +
            'aip_mode = "' + aip_mode + '" ' +
            'aip_slider_number_of_cols = "' + aip_slider_number_of_cols + '" ' +
            'aip_slider_number_of_rows = "' + aip_slider_number_of_rows + '" ' +
            'aip_slider_height = "' + aip_slider_height + '" ' +
            'aip_wall_number_of_cols = "' + aip_wall_number_of_cols + '" ' +
            'aip_wallj_height = "' + aip_wallj_height + '" ' +
            ']';
    jQuery('#aip_shortcode').val(aip_shortcode);
    load_shortcode();
}
function load_shortcode() {
    jQuery('.aip_loader').show();
    setTimeout(function () {
        var value = jQuery('#aip_shortcode').val();
        var aip_mode = jQuery('#aip_mode_hidden').val();
        jQuery.post(
                ajaxurl,
                {
                    action: 'aip_load_shortcode',
                    value: value
                },
                function (response) {
                    jQuery('#aip_shortcode_loaded').html(response);
                    aip_start_lightcase(ajaxurl);
                    aip_video_hover();
                    setTimeout(function () {
                        aip_slab_hover();
                    }, 2000);
                    jQuery('.aip_loader').hide();
                }
        );



    }, 1000);



}
function hide_settings_elements(element_class) {
    jQuery('.' + element_class).fadeOut();
}
function show_settings_elements(element_class) {
    jQuery('.' + element_class).fadeIn();
}

function aip_start_lightcase(ajaxurl) {
    jQuery('a[data-rel^=lightcase]').magnificPopup({
        type: 'inline',
        gallery: {
            enabled: true
        },
        callbacks: {
            beforeOpen: function () {
            },
            elementParse: function (item) {
                aip_slab_hover();
            },
            open: function () {
                aip_slab_hover();


            },
            change: function () {
                var data_aip_instagram_item_id_lightbox = jQuery(this.currItem.el).attr('href').replace("#", "");

                var data_aip_instagram_item_id = jQuery(this.currItem.el).find('.aip-item-wrapper').attr('data-aip-instagram-item-id');
                var data_aip_instagram_item_likes_count = jQuery(this.currItem.el).find('.aip-item-wrapper').attr('data-aip-instagram-item-likes-count');



                jQuery.post(
                        ajaxurl,
                        {
                            action: 'aip_get_likes_comments',
                            data_aip_instagram_item_id: data_aip_instagram_item_id,
                            data_aip_instagram_item_likes_count: data_aip_instagram_item_likes_count
                        },
                        function (response) {
                            var likes_comments = jQuery.parseJSON(response);
                            if (likes_comments.resp_likes && likes_comments.resp_likes != '') {
                                jQuery('#' + data_aip_instagram_item_id_lightbox + ' .aip_lightbox_content_likes').html('<span>' + likes_comments.resp_likes + '</span>');
                            }
                            jQuery('#' + data_aip_instagram_item_id_lightbox + ' #aip_lightbox_comments_users').html(likes_comments.resp_comments);

                            jQuery('#' + data_aip_instagram_item_id).find(".aip_lightbox2_col").matchHeight({byRow: false, property: "height", target: jQuery('#' + data_aip_instagram_item_id).find(".aip_lightbox_height_ref")});

                            jQuery('#' + data_aip_instagram_item_id).find(".aip_lightbox_content_comments").height(jQuery('#' + data_aip_instagram_item_id).find(".aip_lightbox2_col").height() - (jQuery('#' + data_aip_instagram_item_id).find(".aip_lightbox_autor").outerHeight() + jQuery('#' + data_aip_instagram_item_id).find(".aip_lightbox_content").outerHeight() + jQuery('#' + data_aip_instagram_item_id).find(".aip_lightbox_content_likes").outerHeight()));


                        }
                );

//                aip_lightbox_height();

                jQuery(this.content).fadeIn();
                aip_slab_hover();


            },
            // e.t.c.
        }
    });

}

jQuery(document).ready(function () {
    jQuery('.aip_unlink_user a').on('click', function () {
        jQuery.post(
                ajaxurl,
                {
                    action: 'aip_unlink_user'
                },
                function (response) {
                    if (response == 'true') {
                        location.reload();
                    } else {
                        alert('Error. Please, try again !');
                    }

                }
        );
        return false;
    });
});