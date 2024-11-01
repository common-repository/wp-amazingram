<?php $aip_logged_user = get_option('aip_user'); ?>
<div class="aip_container" style="margin-bottom: 40px;border-bottom: 1px solid #ccc;">
        <div class="aip_user aip_col">
            <div class="aip_user_wrapper">
                <div class="aip_col aip_width_3 aip_single_user_image">
                    <img src="<?php echo $aip_logged_user['data']->profile_picture; ?>" />
                </div>
                <div class="aip_col aip_width_9 aip_single_user">
                    <div class="aip_col aip_width_12 aip_single_user_username"><?php echo $aip_logged_user['data']->username; ?></div>
                    <div class="aip_col aip_width_3 aip_single_user_media">
                        <b><?php echo $aip_logged_user['data']->counts->media; ?></b> post
                    </div>
                    <div class="aip_col aip_width_3 aip_single_user_followed_by">
                        <b><?php echo $aip_logged_user['data']->counts->followed_by; ?></b> follower
                    </div>
                    <div class="aip_col aip_width_6 aip_single_user_follows">
                        <b><?php echo $aip_logged_user['data']->counts->follows; ?></b> persone seguite
                    </div>
                    <div class="aip_col aip_width_12 aip_single_user_description">
                        <b><?php echo $aip_logged_user['data']->full_name; ?></b> <?php echo $aip_logged_user['data']->bio; ?>
                    </div>
                    <div class="aip_col aip_width_12 aip_single_user_website">
                        <b>
                            <a href="<?php echo $aip_logged_user['data']->website; ?>" target="_blank">
                                <?php echo $aip_logged_user['data']->website; ?>
                            </a>
                        </b>
                    </div>
                    <div class="aip_col aip_width_12 aip_single_user_id" style="font-size: 1px;opacity:0;">
                        <?php echo $aip_logged_user['data']->id; ?>
                    </div>

                </div>
            </div>
         <div class="aip_col aip_width_12 aip_unlink_user"><a href="#">UNLINK USER</a></div>
        </div>
       
    </div>