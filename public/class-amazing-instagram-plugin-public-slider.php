<?php

class Amazing_Instagram_Plugin_Free_Public_Slider {

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

    public function aip_slider($data, $atts) {


        //echo '<pre>'; print_r($data); echo '</pre>';

        $uniqid = uniqid();
        $aip_k_rows = 1;
        $class_aip_public = new Amazing_Instagram_Plugin_Free_Public('', '');
        $class_aip_public_type = "instagram";

        $return_hidden = '';
        $return_js = '';
        $aip_slider_class = '';

        if ($atts['aip_support_lp'] == 'true'):
            $aip_slider_class .= ' aip_support_lp_true';
        else:
            $aip_slider_class .= ' aip_support_lp_false';
        endif;


        $return = '<div id="aip-slider-' . $uniqid . '" class="aip-slider swiper-container' . $aip_slider_class . ' aip_slider_card_0" ><div class="swiper-wrapper" >';

        foreach ($data as $single_data):


            $return .= $this->aip_get_item_slider($class_aip_public, $single_data, $atts, $aip_k_rows);
            $return_hidden .= $class_aip_public->aip_hidden_lightbox($single_data, $atts);


            $aip_k_rows++;

        endforeach;




        $return .= '</div>';
        $return .='<i style="color:#666667;" class="swiper-button-prev-' . $uniqid . ' swiper-button-prev fa fa-chevron-left"></i>
                    <i style="color:#666667;" class="swiper-button-next swiper-button-next-' . $uniqid . ' fa fa-chevron-right"></i>';

        $return .= '<div class = "swiper-pagination swiper-pagination-' . $uniqid . '"></div>';
        $return .='<style type="text/css">#aip-slider-' . $uniqid . ' .swiper-pagination-bullet-active { background:#666667 !important; }</style>';


        $return .= '</div>';

        $return .='<div id = "aip-wall-lightbox">' . $return_hidden . ' </div>';


        wp_enqueue_script('swiper.min ', plugins_url('/js/swiper.min.js  ', __FILE__), array('jquery'), '');


        wp_enqueue_style('swiper.min.css', plugins_url('/css/swiper.min.css', __FILE__));




        $return_js .='<script type = "text/javascript">
                function callback(event){
                aip_start_lightcase("' . admin_url('admin-ajax.php') . '");
                }
                </script>';


        $swiper_settings_slider = '';
        
            $swiper_settings_slider .= '
                prevButton: ".swiper-button-prev-' . $uniqid . '",
                nextButton: ".swiper-button-next-' . $uniqid . '",';
        
            $swiper_settings_slider .= '
                pagination: ".swiper-pagination-' . $uniqid . '",
                paginationClickable: true,
            ';
       



        if ($atts['aip_support_lp'] == 'true'):

            $return_swiper_settings = '<script type="text/javascript">
    jQuery(document).ready(function(){
    var AipSwiper' . $uniqid . ' = jQuery("#aip-slider-' . $uniqid . '").swiper({'
                    . $swiper_settings_slider . '
            autoHeight: true,
            autoplay: 0,
            setWrapperSize: true,
            slidesPerView: "auto",
            slidesPerColumn: 1,
            parallax: false,
            loop: true,
            onImagesReady: function(){ aip_slab_hover(); },
            
    }) });
</script>';


            $return .= '<style type="text/css">'
                    . '#aip-slider-' . $uniqid . ' .swiper-wrapper { height: ' . $atts['aip_slider_height'] . 'px !important; }'
                    . '</style>';


        else:




            $return_swiper_settings = '<script type="text/javascript">
    jQuery(document).ready(function(){
    var AipSwiper' . $uniqid . ' = jQuery("#aip-slider-' . $uniqid . '").swiper({'
                    . $swiper_settings_slider . '
            slidesPerView: ' . $atts['aip_slider_number_of_cols'] . ',
            slidesPerColumn: ' . $atts['aip_slider_number_of_rows'] . ',    
            autoplay: 0,
            resistanceRatio: 1,
            onImagesReady: function(){ aip_slab_hover(); },
            
    }) });
</script>';



            $return_js .= '<script type="text/javascript">'
                    . 'jQuery(document).ready( function() {'
                    . 'jQuery("#aip-slider-' . $uniqid . ' .aip-single-item").matchHeight({byRow: false, property: "height", target: jQuery("#aip-slider-' . $uniqid . ' .aip_img_placeholder") });'
                    . '});'
                    . '</script>';




        endif;

        $return_css = '';
            for ($k = 1; $k <= count($data); $k++):

                $s_delay = (0.2 * $k);
                $s_duration = 2;
                $return_css .= '
 .aip-slider .aip_lightbox[data-id="' . $k . '"]{ 
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
 }';
            endfor;
       

        $return_css = '<style type="text/css">' . $return_css . '</style>';



        return $return . $return_swiper_settings . $return_css . $return_js;
    }

    public function aip_get_item_slider($class_aip_public, $single_data, $atts, $aip_k_rows) {

        $aip_item_content = '';
        $aip_item_style = '';
        $aip_item_img_style = '';
        $aip_item_class = 'aip_item_slider';
        $aip_item_a_class = 'aip_lightbox';
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
        $aip_instagram_item_id = $single_data->id;





        $return = '';



            $aip_item_content .= $class_aip_public->aip_generate_hover_effects($single_data, $atts, $aip_k_rows);






        if ($atts['aip_support_lp'] == 'false'):
            $return .= '<div class="swiper-slide">' . $aip_item_content . '</div>';
        else:
            $return .= '<div class="swiper-slide" style="height: 100% !important; width: auto !important;">' . $aip_item_content . '</div>';
        endif;

        return $return;
    }

}
