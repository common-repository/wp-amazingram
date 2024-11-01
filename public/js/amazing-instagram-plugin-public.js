function aip_lightbox_height() {
    jQuery('.aip_hidden_lightbox_instagram').each(function () {

        var data_aip_instagram_item_id_lightbox = jQuery(this).attr('id');

        jQuery('#' + data_aip_instagram_item_id_lightbox).find(".aip_lightbox2_col").matchHeight({byRow: false, property: "height", target: jQuery('#' + data_aip_instagram_item_id_lightbox).find(".aip_lightbox_height_ref")});
        console.log(jQuery('#' + data_aip_instagram_item_id_lightbox).find(".aip_lightbox_height_ref").height());
        jQuery('#' + data_aip_instagram_item_id_lightbox).find(".aip_lightbox_content_comments").height(jQuery('#' + data_aip_instagram_item_id_lightbox).find(".aip_lightbox2_col").height() - (jQuery('#' + data_aip_instagram_item_id_lightbox).find(".aip_lightbox_autor").outerHeight() + jQuery('#' + data_aip_instagram_item_id_lightbox).find(".aip_lightbox_content").outerHeight() + jQuery('#' + data_aip_instagram_item_id_lightbox).find(".aip_lightbox_content_likes").outerHeight()));
    });
}

function aip_slab_hover() {
    jQuery(".aip_vertical_align .aip_hover_author").fitText(0.8, {minFontSize: 12,maxFontSize: 16});
    jQuery(".aip_item_before_content_card a").fitText(0.8, {minFontSize: 12,maxFontSize: 16});
    jQuery(".aip_content_instagram_icon").fitText(0.8, {minFontSize: 12,maxFontSize: 16});
    jQuery(".aip_item_after_content_card p").fitText(0.8, {minFontSize: 12,maxFontSize: 12});
    jQuery(".aip_button_view_instagram a").fitText(0.8, {minFontSize: 12,maxFontSize: 16});
    jQuery(".aip_lightbox_content_comments").fitText(0.8, {minFontSize: 12,maxFontSize: 12});
    jQuery(".aip_hover_caption").fitText(0.8, {minFontSize: 12,maxFontSize: 12});
    aip_caption_size();
}




function aip_shuffle(a) {
    var j, x, i;
    for (i = a.length; i; i--) {
        j = Math.floor(Math.random() * i);
        x = a[i - 1];
        a[i - 1] = a[j];
        a[j] = x;
    }
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
                            data_aip_instagram_item_likes_count: data_aip_instagram_item_likes_count,
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

function aip_video_hover() {
    var figure = jQuery(".aip-item-video");
    var vid = figure.find("video");
    var ajaxurl = AipAjax.ajaxurl;

    [].forEach.call(figure, function (item, index) {
        item.addEventListener("mouseover", hoverVideo.bind(item, index), false);
        item.addEventListener("mouseout", hideVideo.bind(item, index), false);
    });
    function hoverVideo(index, e) {
        vid[index].play();
    }
    function hideVideo(index, e) {
        vid[index].pause();
    }
}


function aip_caption_size() {
    jQuery(".aip_vertical_align").each(function () {
        var current_height = jQuery(this).outerHeight();
        var aip_author = jQuery(this).find(".aip_hover_author").outerHeight();
        var info = jQuery(this).find(".info").outerHeight();
        var aip_hover_caption = jQuery(this).find(".aip_hover_caption").height(current_height - (aip_author + info));

        var current_content_height = aip_author + info + aip_hover_caption;
        if (current_content_height > current_height) {
            jQuery(this).find(".aip_hover_caption.is-truncated").hide();
        }
    });
    setTimeout(function () {
        jQuery(".aip_hover_caption").dotdotdot({wrap: "word"});
    }, 500);
}


function aip_wall_height_support_false() {
    jQuery(".aip-wall-class.aip_wall_card_0 .aip-single-item").matchHeight({byRow: false, property: "height", target: jQuery(".aip-item-image .aip-item-wrapper .aip_img_placeholder")});

}

