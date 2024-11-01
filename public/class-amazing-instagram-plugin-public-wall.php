<?php

class Amazing_Instagram_Plugin_Free_Public_Wall {

    /**
     * The ID of this plugin.
     * 
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function aip_wall($aip_slice_min, $aip_slice_step) {

        $uniqid = Amazing_Instagram_Plugin_Free_Public::aip_read_var('uniqid');
        $data = Amazing_Instagram_Plugin_Free_Public::aip_read_var('data');
        $atts = Amazing_Instagram_Plugin_Free_Public::aip_read_var('atts');
        $data_shuffle = Amazing_Instagram_Plugin_Free_Public::aip_read_var('data_shuffle');
        $aip_wall_main_class = '';

        if ($atts['aip_support_lp'] == 'true'):
            $aip_wall_main_class .= ' aip_support_lp_true';
        else:
            $aip_wall_main_class .= ' aip_support_lp_false';
        endif;


        if ($atts['aip_mode'] == 'wall'):
            $aip_wall_main_class .= ' aip_mode_wall';
        elseif ($atts['aip_mode'] == 'wallj'):
            $aip_wall_main_class .= ' aip_mode_wallj';
        endif;


        $aip_wall_main_class .= ' aip_wall_card_0';

        $class_aip_public = new Amazing_Instagram_Plugin_Free_Public('', '');

        $aip_item_a_class = 'aip_lightbox';
        $return_hidden = '';

        $aip_item_before_content_card = '';
        $aip_item_after_content_card = '';

        if ($aip_slice_step != -1):
            $aip_slice_min = 0;
        endif;

        $item_w = '';
        $item_type = '';
        $item_video_lr = '';
        $item_video_lb = '';
        $item_video_sr = '';
        $aip_item_content = '';

        $aip_caption_text = '';



        $aip_loader = '<div class="loader"><div class="loader-inner ball-pulse"><div></div><div></div><div></div></div></div>';


        $return = '<div id="aip-wall-' . $uniqid . '" class="aip-wall-class ' . $aip_wall_main_class . '" >';

        $array_return = $this->aip_get_sliced_item_wall($atts, $data, $data_shuffle, $aip_slice_min, $aip_slice_step);




        $return .= $array_return['return'];
        $return_hidden = $array_return['return_hidden'];

        $aip_load_more = '';






        $return .= '</div>';
        $return .='<div id="aip-wall-lightbox">' . $return_hidden . '</div>';
        if ($aip_slice_min == 0):
            $aip_slice_min = $aip_slice_step;
        elseif ($aip_slice_min == -1):
            $aip_slice_min = 0;
        endif;


        if ($aip_slice_min != 0):
            if (($aip_slice_min + $aip_slice_step) > count($data_shuffle)):
                $aip_slice_step = count($data_shuffle) - $aip_slice_min;
            endif;

            $aip_load_more = '<div data-aip-slice-min="' . $aip_slice_min . '" data-aip-slice-step="' . $aip_slice_step . '" class="aip_wall_load_more aip_wall_load_more-' . $uniqid . '"><a href="#" style="border-color:#000000; color:#000000">LOAD MORE </a></div>';
        endif;

        $return .= $aip_load_more;
        
        $return_height = '';
        if ($atts['aip_support_lp'] == 'false'):
            $return_height .= 'jQuery("#aip-wall-' . $uniqid . '.aip_wall_card_0 .aip-single-item").matchHeight({byRow: false, property: "height", target: jQuery("#aip-wall-' . $uniqid . ' .aip_img_placeholder") });';
        endif;




        if ($atts['aip_mode'] == 'wall'):

            $return .= '
                <script type="text/javascript">'
                    . ' jQuery(document).ready(function () {'
                    . ' var single_aip_item_width = jQuery("#aip-wall-' . $uniqid . '").width() / ' . $atts['aip_wall_number_of_cols'] . '; '
                    . ' jQuery("#aip-wall-' . $uniqid . '").gridalicious({selector: ".aip-single-item", queue: false, gutter:2,animate: false, width: single_aip_item_width });'
                    . $return_height
                    . ' setTimeout( function() { aip_slab_hover(); }, 2000);'
                    . ' });'
                    . ' </script>';

        elseif ($atts['aip_mode'] == 'wallj'):
            wp_enqueue_script('jquery.justifiedGallery.min', plugins_url('/js/jquery.justifiedGallery.min.js', __FILE__), array('jquery'), '');
            wp_enqueue_style('justifiedGallery.min.css', plugins_url('/css/justifiedGallery.min.css', __FILE__));




            $return .= '
<script type="text/javascript">
    jQuery(document).ready(function () {
    jQuery("#aip-wall-' . $uniqid . '").justifiedGallery({
    rowHeight: ' . $atts['aip_wallj_height'] . ',
            maxRowHeight: ' . ( $atts['aip_wallj_height'] * 1.5 ) . ',
            justifyThreshold: 0.75,
            waitThumbnailsLoad: false,
            fixedHeight: true,
    }).on("jg.complete", function (e) {
    var aip_width = jQuery(this).find(".aip_hover_author").map(function(){
   return jQuery(this).width(); 
}).get();
    var aip_min_width = Math.min.apply(null, aip_width);
   jQuery(this).find(".aip_hover_author").width(aip_min_width);
   jQuery(this).find(".info").width(aip_min_width);'
                    . $return_height
                    . 'aip_slab_hover();
    });
    
    });</script>';


        endif;

        if ($atts['aip_mode'] == 'wallj'):

            $return .= '<script type="text/javascript">
    jQuery(document).ready(function () {
    jQuery(".aip_wall_load_more-' . $uniqid . '").on("click", function() {
    var ajaxurl = AipAjax.ajaxurl;
    var aip_slice_min = jQuery(".aip_wall_load_more-' . $uniqid . '").attr("data-aip-slice-min");
    var aip_slice_step = jQuery(".aip_wall_load_more-' . $uniqid . '").attr("data-aip-slice-step");
    jQuery.post(
            ajaxurl,
    {
    action: "aip_get_load_more",
            data: "' . addslashes(json_encode($data)) . '",
            atts: "' . addslashes(json_encode($atts)) . '",
            data_shuffle: "' . addslashes(json_encode($data_shuffle)) . '",
            aip_slice_min: aip_slice_min,
            aip_slice_step: aip_slice_step
    },
            function (response) {
            var array_reponse = JSON.parse(response);
            jQuery("#aip-wall-' . $uniqid . '").append(array_reponse.return.return);
            jQuery("#aip-wall-lightbox").append(array_reponse.return.return_hidden);
            jQuery("#aip-wall-' . $uniqid . '").justifiedGallery("norewind");'
                    . $return_height
                    . 'aip_video_hover();
            aip_start_lightcase(ajaxurl);
            if (array_reponse.new_aip_slice_min != 0){
            jQuery(".aip_wall_load_more-' . $uniqid . '").attr("data-aip-slice-min", array_reponse.new_aip_slice_min);
            jQuery(".aip_wall_load_more-' . $uniqid . '").attr("data-aip-slice-step", array_reponse.new_aip_slice_step);
            } else{
            jQuery(".aip_wall_load_more-' . $uniqid . '").fadeOut();
            }
            }
    );
    return false;
    }); });</script>';

        elseif ($atts['aip_mode'] == 'wall'):
            $return .= '<script type="text/javascript">
    jQuery(document).ready(function (){
    jQuery(".aip_wall_load_more-' . $uniqid . '").on("click", function() {
    var ajaxurl = AipAjax.ajaxurl;
    var aip_slice_min = jQuery(".aip_wall_load_more-' . $uniqid . '").attr("data-aip-slice-min");
    var aip_slice_step = jQuery(".aip_wall_load_more-' . $uniqid . '").attr("data-aip-slice-step");
    jQuery.post(
            ajaxurl,
    {
    action: "aip_get_load_more",
            data: "' . addslashes(json_encode($data)) . '",
            atts: "' . addslashes(json_encode($atts)) . '",
            data_shuffle: "' . addslashes(json_encode($data_shuffle)) . '",
            aip_slice_min: aip_slice_min,
            aip_slice_step: aip_slice_step
    },
            function (response) {
            var array_reponse = JSON.parse(response);
            
            jQuery("#aip-wall-' . $uniqid . '").gridalicious("append",jQuery(array_reponse.return.return));
            jQuery("#aip-wall-lightbox").append(array_reponse.return.return_hidden);'
                    . $return_height
                    . 'aip_video_hover();
            aip_start_lightcase(ajaxurl);
            if (array_reponse.new_aip_slice_min != 0){
            jQuery(".aip_wall_load_more-' . $uniqid . '").attr("data-aip-slice-min", array_reponse.new_aip_slice_min);
            jQuery(".aip_wall_load_more-' . $uniqid . '").attr("data-aip-slice-step", array_reponse.new_aip_slice_step);
            } else{
            jQuery(".aip_wall_load_more-' . $uniqid . '").fadeOut();
            }
            setTimeout(function(){
            aip_slab_hover();
            }, 800);
            }
    );
    return false;
    }); });</script>';



            if ($atts['aip_support_lp'] == 'false'):
                $return .= '<script type="text/javascript">'
                        . 'jQuery(document).ready( function() {'
                        . ' aip_slab_hover();'
                        . '});'
                        . '</script>';
            endif;





        endif;

        $return_css = '';
            for ($k = 1; $k <= count($data); $k++):

                $s_delay = (0.2 * $k);
                $s_duration = 2;
                $return_css .= '#aip-wall-' . $uniqid . ' .aip_lightbox[data-id="' . $k . '"]{ 
     -webkit-animation-delay:' . $s_delay . 's;
-moz-animation-delay:' . $s_delay . 's;
-ms-animation-delay:' . $s_delay . 's;
-o-animation-delay:' . $s_delay . 's;
animation-delay:' . $s_delay . 's;
    -webkit-animation-duration:' . $s_duration . 's;
-moz-animation-duration:' . $s_duration . 's;
-ms-animation-duration:' . $s_duration . 's;
-o-animation-duration:' . $s_duration . 's;
animation-duration:' . $s_duration . 's;
 }
  #aip-wall-' . $uniqid . ' .aip_card[data-id="' . $k . '"]{ 
     -webkit-animation-delay:' . $s_delay . 's;
-moz-animation-delay:' . $s_delay . 's;
-ms-animation-delay:' . $s_delay . 's;
-o-animation-delay:' . $s_delay . 's;
animation-delay:' . $s_delay . 's;
    -webkit-animation-duration:' . $s_duration . 's;
-moz-animation-duration:' . $s_duration . 's;
-ms-animation-duration:' . $s_duration . 's;
-o-animation-duration:' . $s_duration . 's;
animation-duration:' . $s_duration . 's;
 }
 ';
            endfor;
     

        $return_css = '<style type="text/css">' . $return_css . '</style>';

        return $return . $return_css;
    }

    public function aip_get_item_wall($atts, $single_data, $key_effect) {

        $class_aip_public = new Amazing_Instagram_Plugin_Free_Public('', '');


        $aip_caption_text = '';




        $aip_number_of_comments = $single_data->comments->count;
        $aip_number_of_likes = $single_data->likes->count;
        $aip_tags = $single_data->tags; // Array
        $aip_link = $single_data->link;





        if (!empty((array) $single_data->caption)):
            $aip_caption_text = $single_data->caption->text;
        endif;

        $aip_user_username = $single_data->user->username;
        $aip_user_profile_picture = $single_data->user->profile_picture;
        $aip_user_full_name = $single_data->user->full_name;


        $aip_item_a_class = 'aip_lightbox ';

        $item_type = $single_data->type;
        $item_image_sr = $single_data->images->low_resolution;
        $item_image_lr = $single_data->images->standard_resolution;
        $item_image_t = $single_data->images->thumbnail;
        $aip_item_content = '';
        $aip_item_class = '';
        $data_h = $item_image_sr->height;






        
            $aip_item_content .= $class_aip_public->aip_generate_hover_effects($single_data, $atts, $key_effect);
     


        return $aip_item_content;
    }

    public function aip_get_sliced_item_wall($atts, $data, $data_shuffle, $aip_slice_min, $aip_slice_step) {
        $class_aip_public = new Amazing_Instagram_Plugin_Free_Public('', '');
        $data_to_render = $class_aip_public->aip_slice_data($data, $data_shuffle, $aip_slice_min, $aip_slice_step);
        $aip_slice_step = $aip_slice_step - $aip_slice_min;
        $return = '';
        $return_hidden = '';


        $data_effects_item = array_keys($data_to_render);
        /*
          echo '<pre>';  print_r(array_keys($data)); echo '</pre>';
          echo '<pre>';  print_r(array_keys($data_shuffle)); echo '</pre>';
          echo '<pre>';  print_r(array_keys($data_to_render)); echo '</pre>';
         */


        foreach ($data_to_render as $key => $single_data):




            $return .= $this->aip_get_item_wall($atts, $single_data, $data_effects_item[$key]);
            $return_hidden .= $class_aip_public->aip_hidden_lightbox($single_data, $atts);

        endforeach;


        $array_return = array(
            'return' => $return,
            'return_hidden' => $return_hidden
        );

        return $array_return;
    }

}
