<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.poivediamo.com/poivediamo/
 * @since      1.0.0
 *
 * @package    Amazing_Instagram_Plugin_Free
 * @subpackage Amazing_Instagram_Plugin_Free/admin/partials
 */
$aip_user = get_option('aip_user');
?>
<div class="aip_loader">
    <div class="sk-cube-grid">
        <div class="sk-cube sk-cube1"></div>
        <div class="sk-cube sk-cube2"></div>
        <div class="sk-cube sk-cube3"></div>
        <div class="sk-cube sk-cube4"></div>
        <div class="sk-cube sk-cube5"></div>
        <div class="sk-cube sk-cube6"></div>
        <div class="sk-cube sk-cube7"></div>
        <div class="sk-cube sk-cube8"></div>
        <div class="sk-cube sk-cube9"></div>
    </div>
</div>
<?php if (is_array($aip_user) && count($aip_user) > 0): ?>
    <div class="aip_logo_landscape"><img src="<?php echo plugin_dir_url(dirname(__FILE__)) . 'img/amazingram-landscape.png'; ?>" /></div>
    <?php include('amazing-instagram-plugin-admin-display-user.php'); ?>

    <div class="aip_col aip_width_3 aip_settings_menu">
        <div class="aip_settings_wrapper">
            <div class="aip_settings_tabs ">

                <div data-pws-tab="aip_tab_source" data-pws-tab-icon="fa-instagram" data-pws-tab-name="Source">
                    <?php include('amazing-instagram-plugin-admin-display-source.php'); ?>
                </div>
                <div data-pws-tab="aip_tab_settings" data-pws-tab-icon="fa-cogs" data-pws-tab-name="Settings">
                    <?php include('amazing-instagram-plugin-admin-display-settings.php'); ?>
                </div>
                <div data-pws-tab="aip_tab_view_mode" data-pws-tab-icon="fa-sliders" data-pws-tab-name="View Mode">
                    <?php include('amazing-instagram-plugin-admin-display-mode_view.php'); ?>
                </div>
                <div data-pws-tab="aip_tab_style" data-pws-tab-icon="fa-tint" data-pws-tab-name="Style">
                    <?php include('amazing-instagram-plugin-admin-display-style.php'); ?>
                </div>

            </div>
            <div class="aip_col aip_width_12" style="margin-top: 20px; ">
                <h4>SHORTCODE</h4>
                <textarea readonly id="aip_shortcode"></textarea>
            </div>
            <input type="hidden" id="aip_support_lp_hidden" value="true"/>
            <input type="hidden" id='aip_mode_hidden' value='wall' />
            <input type="hidden" id="aip_slider_number_of_cols_hidden" value="4" />
            <input type="hidden" id="aip_slider_number_of_rows_hidden" value="1" />
            <input type="hidden" id="aip_slider_height_hidden" value="200" />
            <input type="hidden" id="aip_wall_number_of_cols_hidden" value="4" />
            <input type="hidden" id="aip_wallj_height_hidden" value="150" />
        </div>


    </div>


    <div class="aip_col aip_width_9 aip_settings_shortcode">
        <div class="aip_settings_wrapper">
            <div style="width:100%;" id="aip_shortcode_loaded">
            </div>
        </div>
    </div>

    <?php
else:
    ?>
    <div class="aip-admin-welcome">
        <img src="<?php echo plugin_dir_url(dirname(__FILE__)) . 'img/amazingram-welcome.png'; ?>" />
    </div>
    <?php
    $this->aip_get_access_token('ADD USER');
endif;
?>
