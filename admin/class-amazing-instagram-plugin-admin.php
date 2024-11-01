<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.poivediamo.com/poivediamo/
 * @since      1.0.0
 *
 * @package    Amazing_Instagram_Plugin_Free
 * @subpackage Amazing_Instagram_Plugin_Free/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Amazing_Instagram_Plugin_Free
 * @subpackage Amazing_Instagram_Plugin_Free/admin
 * @author     Poi Vediamo <poivediamo@poivediamo.com>
 */
class Amazing_Instagram_Plugin_Free_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;
    private $option_name = 'Amazing_Instagram_Plugin_Free_';

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
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles($hook) {

        if ($hook !== 'toplevel_page_amazing-instagram-plugin') {
            return;
        }
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/amazing-instagram-plugin-admin.css', array(), $this->version, 'all');
        wp_enqueue_style('resp', plugin_dir_url(__FILE__) . 'css/responsive.gs.12col.css', array(), $this->version, 'all');
        wp_enqueue_style('square_purple', plugin_dir_url(__FILE__) . 'css/skins/square/purple.css', array(), $this->version, 'all');
        wp_enqueue_style('line_purple', plugin_dir_url(__FILE__) . 'css/skins/line/purple.css', array(), $this->version, 'all');
        wp_enqueue_style('jquery.pwstabs.min', plugin_dir_url(__FILE__) . 'css/jquery.pwstabs.min.css', array(), $this->version, 'all');
        wp_enqueue_style('font-awesome', plugin_dir_url(__FILE__) . 'css/font-awesome.css', array(), $this->version, 'all');
        wp_enqueue_style('selectize', plugin_dir_url(__FILE__) . 'css/selectize.css', array(), $this->version, 'all');
        wp_enqueue_style('lightcasecss', plugins_url('/public/css/lightcase.css', dirname(__FILE__)));
        wp_enqueue_style('aip_hover_effects', plugins_url('/public/css/aip_hover_effects.css', dirname(__FILE__)));
        wp_enqueue_style('font-awesome', plugins_url('/css/font-awesome.css', __FILE__));
        wp_enqueue_style('amazing-instagram-plugin-public.css', plugins_url('public/css/amazing-instagram-plugin-public.css', dirname(__FILE__))
        );
        wp_enqueue_style('justifiedGallery.min.css', plugins_url('/public/css/justifiedGallery.min.css', dirname(__FILE__)));
        wp_enqueue_style('swiper.min.css', plugins_url('/public/css/swiper.min.css', dirname(__FILE__)));
        wp_enqueue_style('animation', plugins_url('/public/css/animate.css', dirname(__FILE__)), array(), '', 'all');
        wp_enqueue_style('magnific-popup', plugins_url('/public/css/magnific-popup.css', dirname(__FILE__)), array(), '', 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts($hook) {
        if ($hook !== 'toplevel_page_amazing-instagram-plugin') {
            return;
        }
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/amazing-instagram-plugin-admin.js', array('jquery'), $this->version, false);
        wp_localize_script($this->plugin_name, 'AipAjax', array('ajaxurl' => admin_url('admin-ajax.php')));
        wp_enqueue_script('jquery.dotdotdot.min', plugins_url('/public/js/jquery.dotdotdot.min.js', dirname(__FILE__)), array('jquery'), '');
        wp_enqueue_script('jquery.fittext', plugins_url('/public/js/jquery.fittext.js', dirname(__FILE__)), array('jquery'), '');
        wp_enqueue_script('icheck.min', plugin_dir_url(__FILE__) . 'js/icheck.min.js', array('jquery'), $this->version, false);
        wp_enqueue_script('jquery.pwstabs.min', plugin_dir_url(__FILE__) . 'js/jquery.pwstabs.min.js', array('jquery'), $this->version, false);
        wp_enqueue_script('selectize.min', plugin_dir_url(__FILE__) . 'js/selectize.min.js', array('jquery'), $this->version, false);
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('lightcase', plugins_url('/public/js/lightcase.js', dirname(__FILE__)), array('jquery'), '');
        wp_enqueue_script('amazing-instagram-plugin-public.js', plugins_url('public/js/amazing-instagram-plugin-public.js', dirname(__FILE__)), array('jquery'), $this->version, false);
        wp_localize_script('lightcase', 'AipAjax', array('ajaxurl' => admin_url('admin-ajax.php')));
        wp_localize_script('amazing-instagram-plugin-public.js', 'AipAjax', array('ajaxurl' => admin_url('admin-ajax.php')));

        wp_enqueue_script('jquery.justifiedGallery.min', plugins_url('/public/js/jquery.justifiedGallery.min.js', dirname(__FILE__)), array('jquery'), '');
        wp_enqueue_script('swiper.min', plugins_url('/public/js/swiper.min.js', dirname(__FILE__)), array('jquery'), '');
        wp_enqueue_script('jquery.matchHeight-min', plugins_url('/public/js/jquery.matchHeight-min.js', dirname(__FILE__)), array('jquery'), '');

        wp_enqueue_script('jqColorPicker.min', plugin_dir_url(__FILE__) . 'js/jqColorPicker.min.js', array('jquery'), '');
        wp_enqueue_script('colors', plugin_dir_url(__FILE__) . 'js/colors.js', array('jquery'), '');
        wp_enqueue_script('jquery.grid-a-licious', plugins_url('/public/js/jquery.grid-a-licious.js', dirname(__FILE__)), array('jquery'), '');
        wp_enqueue_script('jquery.magnific-popup.min', plugins_url('/public/js/jquery.magnific-popup.min.js', dirname(__FILE__)), array('jquery'), '');
        wp_enqueue_script('bindWithDelay', plugin_dir_url(__FILE__) . 'js/bindWithDelay.js', array('jquery'), '');
        
        
    }

    public function add_menu_page() {


        $this->plugin_screen_hook_suffix = add_menu_page(
                __('WP Amazingram - Free', 'amazing-instagram'), __('WP Amazingram - Free', 'amazing-instagram'), 'manage_options', $this->plugin_name, array($this, 'amazing_instagram_display_options_page'), plugin_dir_url(__FILE__) . 'img/amazingram.png'
        );
    }

    public function amazing_instagram_display_options_page() {
        echo '<div class="aip_admin_main_settings">';
        include_once 'partials/amazing-instagram-plugin-admin-display.php';
        echo '</div>';
    }

    public function aip_get_access_token($button_text) {


        $aip_logged_user = get_option('$aip_logged_user');
        $aip_client_id = get_option('aip_clientid');
        $aip_callback = get_option('aip_callback');
        if (isset($_GET['aip_access_token']) && $_GET['aip_access_token'] != ''):
            $aip_access_token = $_GET['aip_access_token'];
            $this->aip_add_user($aip_access_token);
        else:
            echo '<div class="aip_link_user"><a href="' . $aip_callback . '?client_id=' . $aip_client_id . '&redirect_uri=' . $aip_callback . '&current_url=' . admin_url('options-general.php?page=amazing-instagram-plugin') . '" id="aip_get_access_token">' . $button_text . '</a></div>';
        endif;
    }

    public function aip_add_user($aip_access_token) {


        $aip_logged_user = get_option('aip_user');
        if ($aip_access_token && $aip_access_token != ''):
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => 'https://api.instagram.com/v1/users/self/?access_token=' . $aip_access_token
            ));
            $resp = json_decode(curl_exec($curl));
            curl_close($curl);
            if (property_exists($resp, 'meta')):
                if ($resp->meta->code == '200'):
                    $aip_resp_data = $resp->data;
                    $aip_user_id = $aip_resp_data->id;
                    $aip_logged_user = array(
                        'access_token' => $aip_access_token,
                        'data' => $aip_resp_data
                    );
                    update_option('aip_user', $aip_logged_user);
                else:
                    $aip_errore_type = $resp->OAuthAccessTokenException;
                    $aip_errore_message = $resp->error_message;
                endif;
            endif;
            ?>
            <script type="text/javascript"> location.href = "<?php echo admin_url('admin.php?page=amazing-instagram-plugin'); ?>";</script>
            <?php
        endif;
    }

}

add_action('wp_ajax_aip_add_item_source', 'aip_add_item_source_cb_free');
add_action('wp_ajax_nopriv_aip_add_item_source', 'aip_add_item_source_cb_free');

function aip_add_item_source_cb_free() {

    $aip_user = get_option('aip_user');
    $aip_access_token = $aip_user['access_token'];


    $values = $_POST['value'];
    if ($values && $values != ''):
        $array_source_values = explode(',', $values);
    endif;
    foreach ($array_source_values as $key => $single_source_val):
        switch (substr($single_source_val, 0, 1)):
            case '#':
                $array_source_values[$key] = $single_source_val;
                break;
            case '!':
                $array_source_values[$key] = 'località';
                //$data[] = $this->aip_get_location_images(substr($single_source_val, 1), $aip_access_token);
                break;
            case '?':
                if (substr($single_source_val, 1) == 'liked'):
                    $array_source_values[$key] = 'liked';
                endif;
                break;
            case '@':

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => 'https://api.instagram.com/v1/users/search?q=' . substr($single_source_val, 1) . '&access_token=' . $aip_access_token
                ));
                $resp = json_decode(curl_exec($curl));
                curl_close($curl);

                if (!empty((array) $resp->data)):
                    $array_source_values[$key] = $resp->data[0]->id;
                else:
                    unset($array_source_values[$key]);
                endif;


                break;
        endswitch;
    endforeach;

    echo implode(',', $array_source_values);

    die();
}

add_action('wp_ajax_aip_exclude_source', 'aip_exclude_source_cb_free');
add_action('wp_ajax_nopriv_aip_exclude_source', 'aip_exclude_source_cb_free');

function aip_exclude_source_cb_free() {

    $aip_user = get_option('aip_user');
    $aip_access_token = $aip_user['access_token'];
    $values = $_POST['value'];
    $values;
    if ($values && $values != ''):
        $array_source_values = explode(',', $values);
    endif;

    foreach ($array_source_values as $key => $aip_single_excluded):
        switch (substr($aip_single_excluded, 0, 1)):
            case '#':
                $array_source_values[$key] = $aip_single_excluded;
                break;
            case '@':
                $array_source_values[$key] = $aip_single_excluded;
                break;
            default:
                if (trim(substr($aip_single_excluded, 0, 1)) && trim(substr($aip_single_excluded, 0, 1)) != ''):
                    $array_source_values[$key] = $aip_single_excluded;
                endif;
                break;
        endswitch;

    endforeach;


    echo implode(',', $array_source_values);

    die();
}

add_action('wp_ajax_aip_load_shortcode', 'aip_load_shortcode_cb_free');
add_action('wp_ajax_nopriv_aip_load_shortcode', 'aip_load_shortcode_cb_free');

function aip_load_shortcode_cb_free() {
    $values = stripslashes($_POST['value']);

    echo do_shortcode((string) $values);
    die();
}

add_action('wp_ajax_aip_unlink_user', 'aip_unlink_user_callback_free');
add_action('wp_ajax_nopriv_aip_unlink_user', 'aip_unlink_user_callback_free');

function aip_unlink_user_callback_free() {
    if (delete_option('aip_user')):
            echo 'true';
    else:
        echo 'false';
    endif;
    die();
}
