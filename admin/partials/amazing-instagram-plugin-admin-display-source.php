<label style="margin-top: 5px;">Source</label>
<input type="text" id="aip_selected_source" class="demo-default" placeholder="Select a person..." value="@<?php echo $aip_user['data']->username; ?>" disabled />
<label class="aip_link_to_premium"><a target="_blank" href="http://www.bidzillweb.com/wp-amazingram/">Premium Feature</a></label>
<label>Number of images ( or video ) ( for every source items )</label>
<input type="number" id="aip_selected_items_number" value="20" disabled />
<label class="aip_link_to_premium"><a target="_blank" href="http://www.bidzillweb.com/wp-amazingram/">Premium Feature</a></label>
<label>Exclude from feed </label>
<input type="text" id="aip_selected_exclude" value="" disabled/>
<label>Random Feed ?</label>
<input type="radio" name="aip_selected_source_random" class="aip_square" value="false" checked disabled> No
<input type="radio" name="aip_selected_source_random" class="aip_square" value="true" disabled> Yes
<br />
<label class="aip_link_to_premium"><a target="_blank" href="http://www.bidzillweb.com/wp-amazingram/">Premium Feature</a></label>
<label>Cache ( in minutes , 0 to deactivate it )</label>
<input type="number" id="aip_cache" value="0" disabled />
<label class="aip_link_to_premium"><a target="_blank" href="http://www.bidzillweb.com/wp-amazingram/">Premium Feature</a></label>
