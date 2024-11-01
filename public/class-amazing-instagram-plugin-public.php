<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.poivediamo.com/poivediamo/
 * @since      1.0.0
 *
 * @package    Amazing_Instagram_Plugin_Free
 * @subpackage Amazing_Instagram_Plugin_Free/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Amazing_Instagram_Plugin_Free
 * @subpackage Amazing_Instagram_Plugin_Free/public
 * @author     Poi Vediamo <poivediamo@poivediamo.com>
 */
class Amazing_Instagram_Plugin_Free_Public {

    private $plugin_name;
    private $version;
    private static $aip_data = array();

    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public static function aip_write_var($key, $value) {
        $aip_data['test'] = 'okokok';
        self::$aip_data[$key] = $value;
    }

    public static function aip_read_var($key) {
        return self::$aip_data[$key];
    }

    public function enqueue_styles() {

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/amazing-instagram-plugin-public.css', array(), $this->version, 'all');
        wp_enqueue_style('loaders.min', plugin_dir_url(__FILE__) . 'css/loaders.min.css', array(), '', 'all');
        wp_enqueue_style('animation', plugin_dir_url(__FILE__) . 'css/animate.css', array(), '', 'all');
        wp_enqueue_style('magnific-popup', plugin_dir_url(__FILE__) . 'css/magnific-popup.css', array(), '', 'all');
    }

    public function enqueue_scripts() {

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/amazing-instagram-plugin-public.js', array('jquery'), $this->version, false);
        wp_localize_script($this->plugin_name, 'AipAjax', array('ajaxurl' => admin_url('admin-ajax.php')));
        wp_enqueue_script('jquery.matchHeight-min', plugins_url('/js/jquery.matchHeight-min.js', __FILE__), array('jquery'), '');
        wp_enqueue_script('jquery.fittext', plugins_url('/js/jquery.fittext.js', __FILE__), array('jquery'), '');
        wp_enqueue_script('jquery.dotdotdot.min', plugins_url('/js/jquery.dotdotdot.min.js', __FILE__), array('jquery'), '');
        wp_enqueue_script('jquery.grid-a-licious', plugins_url('/js/jquery.grid-a-licious.js', __FILE__), array('jquery'), '');
        wp_enqueue_script('jquery.magnific-popup.min', plugins_url('/js/jquery.magnific-popup.min.js', __FILE__), array('jquery'), '');
    }

    public function aip_get_user_images($user_id, $aip_access_token) {


        if ($user_id && $user_id != ''):
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => 'https://api.instagram.com/v1/users/' . $user_id . '/media/recent?access_token=' . $aip_access_token
            ));


            $resp = json_decode(curl_exec($curl));
            curl_close($curl);

            if (property_exists($resp, 'meta')):
                if ($resp->meta->code == '200'):
                    $data = $resp->data;
                    return $data;
                else:
                    $aip_errore_type = $resp->meta->error_type;
                    $aip_errore_message = $resp->meta->error_message;
                endif;
            endif;
        endif;
    }

    public function aip_get_location_images($location_id, $aip_access_token) {
        if ($location_id && $location_id != ''):

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => 'https://api.instagram.com/v1/locations/' . $location_id . '/media/recent?access_token=' . $aip_access_token
            ));

            $resp = json_decode(curl_exec($curl));
            curl_close($curl);
            if (property_exists($resp, 'meta')):
                if ($resp->meta->code == '200'):
                    $data = $resp->data;
                    return $data;
                else:
                    $aip_errore_type = $resp->meta->error_type;
                    $aip_errore_message = $resp->meta->error_message;
                endif;
            endif;
        endif;
    }

    public function aip_get_liked_images($aip_access_token) {

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.instagram.com/v1/users/self/media/liked?access_token=' . $aip_access_token
        ));

        $resp = json_decode(curl_exec($curl));



        curl_close($curl);
        if (property_exists($resp, 'meta')):
            if ($resp->meta->code == '200'):
                $data = $resp->data;
                return $data;
            else:
                $aip_errore_type = $resp->meta->error_type;
                $aip_errore_message = $resp->meta->error_message;
            endif;
        endif;
    }

    public function aip_hidden_lightbox($single_data, $atts) {

        $uniqid = Amazing_Instagram_Plugin_Free_Public::aip_read_var('uniqid');
        $aip_lightbox_content = '';
        $aip_lightbox_class = '';
        $aip_caption_text = '';

        if (!empty((array) $single_data->caption)):
            $aip_caption_text = $single_data->caption->text;
        endif;

        if ($single_data->images->low_resolution->width > $single_data->images->low_resolution->height):
            $aip_lightbox_class .= 'aip-item-landscape ';
        elseif ($single_data->images->low_resolution->width < $single_data->images->low_resolution->height):
            $aip_lightbox_class .= 'aip-item-portrait ';
        elseif ($single_data->images->low_resolution->width == $single_data->images->low_resolution->height):
            $aip_lightbox_class .= 'aip-item-square ';
        endif;


        $aip_item_image_url = '';
        $aip_item_video_url = '';
        $aip_item_standard_video_url = '';
        $aip_item_low_video_url = '';

        $aip_item_standard_image_url = $single_data->images->standard_resolution->url;
        $aip_item_low_image_url = $single_data->images->low_resolution->url;
        if ($single_data->type == 'video'):
            $aip_item_standard_video_url = $single_data->videos->standard_resolution->url;
            $aip_item_low_video_url = $single_data->videos->low_resolution->url;
        endif;

        $aip_item_image_url = $aip_item_low_image_url;
        /*
          if ($single_data->images->low_resolution->height > $single_data->images->low_resolution->width): // portrait
          $aip_item_standard_image_url = 'http://localhost/test/wp-content/uploads/2016/09/placeholder-portrait.jpg';
          elseif ($single_data->images->low_resolution->height < $single_data->images->low_resolution->width): // landscape
          $aip_item_standard_image_url = 'http://localhost/test/wp-content/uploads/2016/09/placeholder-landscape.jpg';
          else:
          $aip_item_standard_image_url = 'http://localhost/test/wp-content/uploads/2016/09/frecce.jpg';
          endif;

         */

        if ($single_data->type == 'image'):
            $aip_lightbox_content = '<img class="aip_lightbox_image aip_lightbox_height_ref ' . $aip_lightbox_class . '" src="' . $aip_item_standard_image_url . '" />';
        elseif ($single_data->type == 'video'):
            $aip_lightbox_content = '<video class="aip_lightbox_height_ref" style="display:block" width="' . $single_data->videos->standard_resolution->width . '" height="' . $single_data->videos->standard_resolution->height . '" id="aip_lightbox_video_' . $single_data->id . '" preload="none" controls muted autoplay> <source src="' . $aip_item_standard_video_url . '" type="video/mp4"> Your browser does not support the video tag. </video>';
        endif;

        $return_hidden = '<div id="' . $single_data->id . '_' . $uniqid . '" class="aip_hidden_lightbox_instagram aip_hidden_lightbox_instagram_' . $single_data->type . ' aip_row " style="display: none;">';

        $return_hidden .= '<div class="aip_hidden_lightbox_instagram_wrapper"><div style="height:' . $single_data->images->standard_resolution->height . 'px;" class="aip_col aip_width_62 aip_lightbox2_left_col aip_lightbox2_col ' . $aip_lightbox_class . '">' . $aip_lightbox_content . '</div>'
                . '<div style="height:' . $single_data->images->standard_resolution->height . 'px;" class="aip_col aip_width_38 aip_lightbox2_right_col aip_lightbox2_col">'
                . '<div class="aip_lightbox_autor">'
                . '<div class="aip_width_12 aip_col">'
                . '<a style="color: #000000;" target="_blank" href="https://www.instagram.com/' . $single_data->user->username . '">'
                . '<img class="" src="' . $single_data->user->profile_picture . '" />'
                . '<span class="aip_lightbox_author_name" style="color: #000000;">' . $single_data->user->username . '</span>'
                . '</a>'
                . '</div>'
                . '</div>'
                . '<div class="aip_width_12 aip_col">'
                . '<div class="aip_content_instagram_icon" style="color: #666667;">'
                . '<span class="aip_hover_icon"><i class="fa fa-heart"></i>' . $single_data->likes->count . '</span>'
                . '<span class="aip_hover_icon"><i class="fa fa-comment"></i>' . $single_data->comments->count . '</span>'
                . '</div>'
                . '</div>'
                . '<div class="aip_col aip_lightbox_content" style="color: #666667;">'
                . $aip_caption_text
                . '</div>'
                . '<div class="aip_col aip_lightbox_content_likes" style="color: #666667;"></div>'
                . '<div class="aip_col aip_lightbox_content_comments" style="color: #666667;"><span id="aip_lightbox_comments_users"></span></div>'
                . '<div class="aip_lightbox_view"><div class="aip_button_view_instagram" style="border-color: #000000";><a style="color: #000000;" target="_blank" href="' . $single_data->link . '"><i class="fa fa-instagram"></i>VIEW ON INSTAGRAM</a></div></div>'
                . '</div></div>';
        $return_hidden .= '</div>';


        wp_enqueue_style('resp', plugin_dir_url(dirname(__FILE__)) . '/admin/css/responsive.gs.12col.css', array(), $this->version, 'all');



        return $return_hidden;
    }

    public function aip_key_excluded_users($data, $user) {
        $key_data_id = array();

        foreach ($data as $single_data):
            $data_id = $single_data->id;
            $users_in_photo = $single_data->users_in_photo;
            foreach ($users_in_photo as $single_users_in_photo):
                if ($single_users_in_photo->user->username == $user):
                    $key_data_id[] = $data_id;
                endif;
            endforeach;
        endforeach;

        return $key_data_id;
    }

    public function aip_key_excluded_tags($data, $tag) {
        $key_data_id = array();

        foreach ($data as $single_data):
            $data_id = $single_data->id;
            $tags_in_photo = $single_data->tags;
            foreach ($tags_in_photo as $single_tag_in_photo):
                if ($single_tag_in_photo == $tag):
                    $key_data_id[] = $data_id;
                endif;
            endforeach;
        endforeach;

        return $key_data_id;
    }

    public function aip_key_excluded_caption($data, $word) {
        $key_data_id = array();

        foreach ($data as $single_data):
            $data_id = $single_data->id;

            $caption_in_photo = $single_data->caption;
            if (!empty((array) $caption_in_photo)):
                $caption_in_photo_text = $caption_in_photo->text;
                if (strpos($caption_in_photo_text, $word) !== false):
                    $key_data_id[] = $data_id;
                endif;
            endif;
        endforeach;

        return $key_data_id;
    }

    public function aip_unset_data($data, $key) {

        foreach ($data as $key_data => $single_data):
            if (in_array($single_data->id, $key)):
                unset($data[$key_data]);
            endif;
        endforeach;

        return $data;
    }

    public function aip_generate_hover_effects($single_data, $atts, $key_effetcs) {

        //echo '<pre>'; print_r($single_data); echo '</pre>';

        $uniqid = Amazing_Instagram_Plugin_Free_Public::aip_read_var('uniqid');


        $key_effetcs = $key_effetcs + 1;
        $aip_get_before_card = '';
        $aip_item_content = '';
        $aip_item_class = 'aip-single-item ';
        $aip_caption_text = '';
        if (!empty((array) $single_data->caption)):
            $aip_caption_text = $single_data->caption->text;
        endif;

        $aip_user_username = $single_data->user->username;
        $aip_user_profile_picture = $single_data->user->profile_picture;
        $aip_user_full_name = $single_data->user->full_name;
        $aip_number_of_likes = $single_data->likes->count;
        $aip_number_of_comments = $single_data->comments->count;


        $aip_support_lp_style = '';
        $aip_item_a_class = 'aip_lightbox ';
        $aip_item_a_class .=' aip_hover aip_eff_hover1';
        $item_type = $single_data->type;
        $item_image_sr = $single_data->images->low_resolution;
        $item_image_lr = $single_data->images->low_resolution;
        $item_image_t = $single_data->images->thumbnail;


        $data_h = $item_image_sr->height;
        $item_type = $single_data->type;
        $return_js = '';

        $aip_video_overlay = '';
        if ($single_data->type == 'video'):
            $aip_video_overlay = '<div class="aip-video-overlay"></div>';
            $aip_item_class .= 'aip-item-video ';
        else:
            $aip_item_class .= 'aip-item-image ';
        endif;
        //echo '<pre>'; print_r($item_image_sr); echo '</pre>';

        if ($single_data->images->low_resolution->width > $single_data->images->low_resolution->height):
            $aip_item_class .= 'aip-item-landscape ';
        elseif ($single_data->images->low_resolution->width < $single_data->images->low_resolution->height):
            $aip_item_class .= 'aip-item-portrait ';
        elseif ($single_data->images->low_resolution->width == $single_data->images->low_resolution->height):
            $aip_item_class .= 'aip-item-square ';
        endif;

        $aip_item_image_url = '';
        $aip_item_video_url = '';
        $aip_item_standard_video_url = '';
        $aip_item_low_video_url = '';


        $aip_item_standard_image_url = $single_data->images->standard_resolution->url;
        $aip_item_low_image_url = $single_data->images->low_resolution->url;
        if ($single_data->type == 'video'):
            $aip_item_standard_video_url = $single_data->videos->standard_resolution->url;
            $aip_item_low_video_url = $single_data->videos->low_resolution->url;
        endif;


        $aip_item_image_url = $aip_item_low_image_url;

        /*
          if ($single_data->images->low_resolution->height > $single_data->images->low_resolution->width): // portrait
          $aip_item_image_url = 'http://localhost/test/wp-content/uploads/2016/09/placeholder-portrait-e1474647776858.jpg';
          elseif ($single_data->images->low_resolution->height < $single_data->images->low_resolution->width): // landscape
          $aip_item_image_url = 'http://localhost/test/wp-content/uploads/2016/09/placeholder-landscape-e1474647726517.jpg';
          else:
          $aip_item_image_url = 'http://localhost/test/wp-content/uploads/2016/09/frecce-e1474647554872.jpg';
          endif;
         */
        switch ($item_type):
            case 'video':
                $aip_item_class .= 'aip-item-video ';

                if ($atts['aip_support_lp'] == 'true'):
                    switch ($atts['aip_mode']):
                        case 'slider':
                            $aip_support_lp_style .= ' height: 100% !important; width auto !important;';
                            $aip_item_content = '<div data-aip-instagram-item-likes-count="' . $aip_number_of_likes . '" data-aip-instagram-item-id="' . $single_data->id . '"   data-aip-instagram-item-id-lightbox="' . $single_data->id . '_' . $uniqid . '" class="aip-item-wrapper" style="display: block !important; height: 100% !important;"><video muted preload="none" style="height:100%; 1important; width: auto !important;" poster="' . $aip_item_image_url . '"> <source src="' . $aip_item_low_video_url . '" type="video/mp4"> Your browser does not support the video tag. </video><div class="aip-video-overlay"></div></div>';
                            break;
                        case 'wall':
                            $aip_item_content = '<div data-aip-instagram-item-likes-count="' . $aip_number_of_likes . '" data-aip-instagram-item-id="' . $single_data->id . '"   data-aip-instagram-item-id-lightbox="' . $single_data->id . '_' . $uniqid . '" class="aip-item-wrapper" style="max-height: 100%;"><video preload="none" muted style="width: 100%;height:auto !important;display:block !important;" poster="' . $aip_item_image_url . '" ><source src="' . $aip_item_low_video_url . '" type="video/mp4"></video><div class="aip-video-overlay"></div></div>';
                            break;
                        case 'wallj':
                            $aip_item_content = '<div data-aip-instagram-item-likes-count="' . $aip_number_of_likes . '" data-aip-instagram-item-id="' . $single_data->id . '"   data-aip-instagram-item-id-lightbox="' . $single_data->id . '_' . $uniqid . '" class="aip-item-wrapper"><video preload="none" muted style="width:100% !important; max-width: none !important;display:block !important;" poster="' . $aip_item_image_url . '"> <source src="' . $aip_item_low_video_url . '" type="video/mp4"> Your browser does not support the video tag. </video> <div class="aip-video-overlay"></div></div>';
                            break;
                    endswitch;
                else:
                    switch ($atts['aip_mode']):
                        case 'slider':
                            $aip_item_content = '<div data-aip-instagram-item-likes-count="' . $aip_number_of_likes . '" data-aip-instagram-item-id="' . $single_data->id . '"   data-aip-instagram-item-id-lightbox="' . $single_data->id . '_' . $uniqid . '" class="aip-item-wrapper"><video preload="none" muted poster="' . $aip_item_image_url . '"> <source src="' . $aip_item_low_video_url . '" type="video/mp4"> Your browser does not support the video tag. </video><div class="aip-video-overlay"></div></div>';
                            break;
                        case 'wall':
                            $aip_item_content = '<div data-aip-instagram-item-likes-count="' . $aip_number_of_likes . '" data-aip-instagram-item-id="' . $single_data->id . '"  data-aip-instagram-item-id-lightbox="' . $single_data->id . '_' . $uniqid . '" class="aip-item-wrapper" style="max-height: 100%;"><video preload="none" muted style="" poster="' . $aip_item_image_url . '"> <source src="' . $aip_item_low_video_url . '" type="video/mp4"> Your browser does not support the video tag. </video><div class="aip-video-overlay"></div></div>';
                            break;


                    endswitch;
                endif;


                break;
            case 'image':


                if ($atts['aip_support_lp'] == 'true'):
                    switch ($atts['aip_mode']):
                        case 'slider':
                            $aip_item_content = '<div data-aip-instagram-item-likes-count="' . $aip_number_of_likes . '" data-aip-instagram-item-id="' . $single_data->id . '"   data-aip-instagram-item-id-lightbox="' . $single_data->id . '_' . $uniqid . '" class="aip-item-wrapper" style="height:100%; width: auto !important;" ><img  src="' . $aip_item_image_url . '" style="height:100%; width: auto !important; " /></div>' . $aip_video_overlay;
                            $aip_support_lp_style .= ' height: 100% !important; width auto !important;';
                            break;
                        case 'wall':
                            $aip_item_content = '<div data-aip-instagram-item-likes-count="' . $aip_number_of_likes . '" data-aip-instagram-item-id="' . $single_data->id . '"  data-aip-instagram-item-id-lightbox="' . $single_data->id . '_' . $uniqid . '" class="aip-item-wrapper"  style="height:100%; width: auto !important;"><img style="width: 100%; "   src="' . $aip_item_image_url . '" /></div>' . $aip_video_overlay;
                            break;
                        case 'wallj':
                            $aip_item_content = '<div data-aip-instagram-item-likes-count="' . $aip_number_of_likes . '" data-aip-instagram-item-id="' . $single_data->id . '"  data-aip-instagram-item-id-lightbox="' . $single_data->id . '_' . $uniqid . '" class="aip-item-wrapper"><img style="display: block !important;" src="' . $aip_item_image_url . '" /></div>' . $aip_video_overlay;
                            break;
                    endswitch;
                else:

                    switch ($atts['aip_mode']):
                        case 'slider':
                        case 'wall':
                            $aip_item_content = '<div data-aip-instagram-item-likes-count="' . $aip_number_of_likes . '"  data-aip-instagram-item-id="' . $single_data->id . '"  data-aip-instagram-item-id-lightbox="' . $single_data->id . '_' . $uniqid . '" class="aip-item-wrapper" style="background: url(' . $aip_item_image_url . '); background-size: cover; background-repeat: no-repeat; background-position: center center;"><img class="aip_img_placeholder" style="width:100%; max-height: 100%;  opacity:0;" src="' . plugin_dir_url(__FILE__) . 'css/img/placeholder-square.jpg" />' . '</div>';
                            break;
                    endswitch;

                endif;

                break;
        endswitch;



        $effect_item_content_card = '<div class="overlay" style="background-color: rgba(0,0,0,0.5);"><div class="aip_vertical_align"><div class="info"><i class="fa fa-search"></i></div></div></div>';

        $effect_item_content = '<div class="overlay" style="background-color: rgba(0,0,0,0.5);"><div class="aip_vertical_align"><div class="aip_hover_author" style="color: #ffffff;">@' . $aip_user_username . '</div><div class="info"><div class="aip_content_instagram_icon" style="color: #ffffff;"><span class="aip_hover_icon"><i class="fa fa-heart"></i>' . $aip_number_of_likes . '</span><span class="aip_hover_icon"><i class="fa fa-comment"></i>' . $aip_number_of_comments . '</span></div></div><div class="aip_hover_caption" style="color: #ffffff;"><p>' . $aip_caption_text . '</p></div></div></div>	';

        $effect_item_content_7 = '<div class="overlay" style="background-color: rgba(0,0,0,0.5);">
							<div class="info">
                                                        <div class="aip_hover_author" style="color: #ffffff;">@' . $aip_user_username . '</div>
                                                            <div class="aip_content_instagram_icon" style="color: #ffffff;">
								<span class="aip_hover_icon"><i class="fa fa-heart"></i>' . $aip_number_of_likes . '</span>
								<span class="aip_hover_icon"><i class="fa fa-comment"></i>' . $aip_number_of_comments . '</span>
							</div>
							
							
						</div></div>';


        $return_effect_item_content = $effect_item_content;

        $aip_button = '<div class="aip_button_view_instagram" style="border-color: #000000"><a style="color: #000;" target="_blank" href="' . $single_data->link . '"><i class="fa fa-instagram"></i>VIEW ON INSTAGRAM</a></div>';



        $return = '<div '
                . 'class="' . $aip_item_class . '" '
                . 'data-instagram-id = "' . $single_data->id . '" '
                . 'style="border:0px;' . $aip_support_lp_style . '"  >'
                . '<a class="animated fadeIn ' . $aip_item_a_class . '" '
                . 'data-id="' . $key_effetcs . '"'
                . 'href="#' . $single_data->id . '_' . $uniqid . '" '
                . 'data-rel="lightcase:AipLightboxGallery" '
                . 'data-lc-categories="class_test">'
                . $aip_item_content
                . $return_effect_item_content
                . '</a>'
                . '</div>';




        return $return . $return_js;
    }

    public function aip_get_before_card($atts, $single_data, $card) {
        $return = '';
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

        $return = '<div class="aip_item_before_content_card">'
                . '<a style="color: ' . $atts['aip_color_card_author'] . '" href="https://www.instagram.com/' . $aip_user_username . '/" target="_blank">@' . $aip_user_username . '</a>'
                . '</div>';



        return $return;
    }

    public function aip_get_after_card($atts, $single_data, $card) {
        $return = '';
        $aip_number_of_comments = $single_data->comments->count;
        $aip_number_of_likes = $single_data->likes->count;
        $aip_tags = $single_data->tags; // Array
        $aip_link = $single_data->link;
        $aip_caption_text = '';
        if (!empty((array) $single_data->caption)):
            $aip_caption_text = $single_data->caption->text;
        endif;

        $aip_user_username = $single_data->user->username;
        $aip_user_profile_picture = $single_data->user->profile_picture;
        $aip_user_full_name = $single_data->user->full_name;



        $return = '<div class="aip_item_after_content_card">'
                . '<div class="aip_content_instagram_icon" style="color: ' . $atts['aip_color_card_icon'] . ';">'
                . '<span class="aip_hover_icon">'
                . '<i class="fa fa-heart"></i>' . $aip_number_of_likes . '</span>'
                . '<span class="aip_hover_icon">'
                . '<i class="fa fa-comment"></i>' . $aip_number_of_comments . '</span>'
                . '</div>'
                . '<p style="color: ' . $atts['aip_color_card_caption'] . ';">' . $aip_caption_text . '</p>'
                . '</div>';

        return $return;
    }

    public function aip_generate_feed($atts) {
        $aip_logged_user = get_option('aip_user');
        $aip_access_token = $aip_logged_user['access_token'];
        $aip_mode = $atts['aip_mode'];
        $aip_selected_source = array_map('trim', explode(',', $atts['aip_selected_source']));

        foreach ($aip_selected_source as $aip_single_selected_user_tag):
            switch (substr($aip_single_selected_user_tag, 0, 1)):
                case '!':
                    $data[] = $this->aip_get_location_images(substr($aip_single_selected_user_tag, 1), $aip_access_token);
                    break;
                case '?':
                    if (substr($aip_single_selected_user_tag, 1) == 'liked'):
                        $data[] = $this->aip_get_liked_images($aip_access_token);
                    endif;
                    break;
                default:
                    $data[] = $this->aip_get_user_images($aip_single_selected_user_tag, $aip_access_token);
                    break;
            endswitch;

        endforeach;


        if (is_array($data) && count(array_filter($data)) > 0):
            $data = array_reduce($data, 'array_merge', array());
        endif;

        return $data;
    }

    public function aip_render_output($aip_mode, $data, $atts, $data_shuffle, $aip_slice_min, $aip_slice_step) {

        switch ($aip_mode):
            case 'slider':
                $aip_results = new Amazing_Instagram_Plugin_Free_Public_Slider('', '');
                $return = $aip_results->aip_slider($data, $atts);


                break;
            case 'wall':
            case 'wallj':
                $aip_results = new Amazing_Instagram_Plugin_Free_Public_Wall('', '');
                $return = $aip_results->aip_wall($aip_slice_min, $aip_slice_step);
                break;
        endswitch;

        return $return;
    }

    public function aip_slice_data($data, $data_shuffle, $aip_slice_min, $aip_slice_step) {
        if ($aip_slice_min != -1):
            if (($aip_slice_min + $aip_slice_step) > count($data)):
                $aip_slice_step = count($data) - $aip_slice_min - 1;
            endif;
            $data = array_slice($data, $data_shuffle[$aip_slice_min], $data_shuffle[$aip_slice_step]);
        endif;
        return $data;
    }

    public function aip_shortcode_function($atts) {
        $atts = shortcode_atts(
                array(
            'aip_support_lp' => 'false', // true | false
            'aip_mode' => 'slider', // slider | wall | wallj
            'aip_slider_number_of_cols' => 4,
            'aip_slider_number_of_rows' => 1,        
            'aip_slider_height' => 300,
            'aip_wall_number_of_cols' => 4,
            'aip_wallj_height' => 300
                ), $atts
        );


        $return_js = '';

        $uniqid = uniqid();


        if ($atts['aip_support_lp'] == 'false' && $atts['aip_mode'] == 'wallj'):
            $atts['aip_mode'] = 'wall';
        endif;


        $aip_logged_user = get_option('aip_user');
        $aip_access_token = $aip_logged_user['access_token'];
        $aip_blog_id = get_current_blog_id();
        $aip_mode = $atts['aip_mode'];
        $data = array();
        $aip_slice_min = -1;
        $aip_slice_step = -1;

        $class_aip_public = new Amazing_Instagram_Plugin_Free_Public('', '');
        $data_shuffle = range(0, count($data) - 1);
        
        Amazing_Instagram_Plugin_Free_Public::aip_write_var('atts', $atts);
        Amazing_Instagram_Plugin_Free_Public::aip_write_var('aip_access_token', $aip_access_token);
        Amazing_Instagram_Plugin_Free_Public::aip_write_var('aip_blog_id', $aip_blog_id);
        Amazing_Instagram_Plugin_Free_Public::aip_write_var('class_aip_public', $class_aip_public);
        Amazing_Instagram_Plugin_Free_Public::aip_write_var('uniqid', $uniqid);



        if (get_option('aip_user')['data']->id && get_option('aip_user')['data']->id != ''):
            $atts['aip_selected_source'] = get_option('aip_user')['data']->id;
            $data = $this->aip_generate_feed($atts);

            Amazing_Instagram_Plugin_Free_Public::aip_write_var('data', $data);
            Amazing_Instagram_Plugin_Free_Public::aip_write_var('data_shuffle', $data_shuffle);




            $return = $this->aip_render_output($aip_mode, $data, $atts, $data_shuffle, -1, -1);

            wp_enqueue_script('lightcase', plugins_url('/js/lightcase.js', __FILE__), array('jquery'), '');
            wp_localize_script('lightcase', 'AipAjax', array('ajaxurl' => admin_url('admin-ajax.php')));
            wp_enqueue_style('lightcasecss', plugins_url('/css/lightcase.css', __FILE__));
            wp_enqueue_style('aip_hover_effects', plugins_url('/css/aip_hover_effects.css', __FILE__));
            wp_enqueue_style('font-awesome', plugins_url('/css/font-awesome.css', __FILE__));

        endif;





        $return_js .= '<script type="text/javascript">'
                . 'jQuery(document).ready( function(){
                var ajaxurl = "' . admin_url('admin-ajax.php') . '";
                jQuery.post(
                        ajaxurl,
                        {
                            action: "aip_load_likes_comments",
                            aip_blog_id: "' . $aip_blog_id . '",
                            data: "' . addslashes(json_encode($data)) . '",
                            atts: "' . addslashes(json_encode($atts)) . '"
                        }); 
                });
             </script>';


        $return_js .= '<script type="text/javascript">'
                . ' jQuery(document).ready( function(){'
                . ' aip_video_hover();'
                . ' aip_start_lightcase("' . admin_url('admin-ajax.php') . '");'
                . ' });'
                . '</script>';




        $return_loading = '<script type="text/javascript">'
                . 'jQuery(document).ready( function(){'
                . 'setTimeout( function(){'
                . 'jQuery(".aip-wall-class").css("opacity","1");'
                . 'jQuery(".aip-slider").css("opacity","1");'
                . '},100);'
                . '});'
                . '</script>';


        return $return . $return_js . $return_loading;
    }

    public function aip_get_load_more_callback() {

        $atts = json_decode(stripslashes($_POST['atts']), ARRAY_A);
        $data = json_decode(stripslashes($_POST['data']));
        $data_shuffle = json_decode(stripslashes($_POST['data_shuffle']));

        $aip_slice_min = $_POST['aip_slice_min'];
        $aip_slice_step = $_POST['aip_slice_step'];
        $class_aip_public = new Amazing_Instagram_Plugin_Free_Public_Wall('', '');




        $new_aip_slice_min = $aip_slice_min + $aip_slice_step;

        $return = $class_aip_public->aip_get_sliced_item_wall($atts, $data, $data_shuffle, $aip_slice_min, $aip_slice_step);



        if ($new_aip_slice_min >= count($data_shuffle)):
            $new_aip_slice_min = 0;
        endif;

        if (($new_aip_slice_min + $aip_slice_step) > count($data_shuffle)):
            $aip_slice_step = count($data_shuffle) - $new_aip_slice_min;
        endif;



        $array_return = array(
            'return' => $return,
            'new_aip_slice_min' => $new_aip_slice_min,
            'new_aip_slice_step' => $aip_slice_step
        );







        echo json_encode($array_return);

        die();
    }

}

add_action('wp_ajax_aip_get_likes_comments', 'aip_get_likes_comments_callback_free');
add_action('wp_ajax_nopriv_aip_get_likes_comments', 'aip_get_likes_comments_callback_free');

function aip_get_likes_comments_callback_free() {
    $resp_likes = array();
    $resp_comments = array();
    $data_aip_instagram_item_id = $_POST['data_aip_instagram_item_id'];
    $data_aip_instagram_item_likes_count = $_POST['data_aip_instagram_item_likes_count'];
    $access_token = get_option('aip_user')['access_token'];



    if ($data_aip_instagram_item_likes_count < 11 && $data_aip_instagram_item_likes_count != 0):

        $data_likes_json_string = '';
        if (is_array($data_likes_json_string) && count($data_likes_json_string) > 0):
            foreach ($data_likes_json_string as $single_like_data):
                array_push($resp_likes, '<b><a target="_blank" href="https://www.instagram.com/' . $single_like_data->username . '/">' . $single_like_data->username . '</a></b>');
            endforeach;
            $resp_likes_string = 'Likes to ' . implode(', ', $resp_likes);
        endif;

    else:
        $resp_likes_string = '';
    endif;

    $data_comments_json_string = '';
    if (is_array($data_comments_json_string) && count($data_comments_json_string) > 0):
        foreach ($data_comments_json_string as $single_comment_data):
            array_push($resp_comments, '<b><a target="_blank" href="https://www.instagram.com/' . $single_comment_data->from->username . '/">' . $single_comment_data->from->username . '</a></b> ' . $single_comment_data->text);
        endforeach;
        $resp_comments_string = implode('<br />', $resp_comments);
    endif;





    $array_resp = array(
        'resp_likes' => $resp_likes_string,
        'resp_comments' => $resp_comments_string
    );

    echo json_encode($array_resp);

    die();
}

add_action('wp_ajax_aip_load_likes_comments', 'aip_load_likes_comments_callback_free');
add_action('wp_ajax_nopriv_aip_load_likes_comments', 'aip_load_likes_comments_callback_free');

function aip_load_likes_comments_callback_free() {
    $class_aip_public = new Amazing_Instagram_Plugin_Free_Public('', '');

    $aip_blog_id = $_POST['aip_blog_id'];
    $data = json_decode(stripslashes($_POST['data']));
    $atts = json_decode(stripslashes($_POST['atts']));
    $aip_logged_user = get_option('aip_user');
    $aip_access_token = $aip_logged_user['access_token'];

    die();
}
