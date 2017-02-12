<?php
/*
 * EZCAST EZplayer
 *
 * Copyright (C) 2016 Université libre de Bruxelles
 *
 * Written by Michel Jansens <mjansens@ulb.ac.be>
 * 	      Arnaud Wijns <awijns@ulb.ac.be>
 *            Carlos Avidmadjessi
 * UI Design by Julien Di Pietrantonio
 *
 * This software is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or (at your option) any later version.
 *
 * This software is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this software; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */
?>
<?php
include_once 'lib_print.php';
?> 

<h2><b><?php echo print_info($asset_meta['title']); ?></b> (<?php echo ($type == 'cam') ? 'Video' : 'Slides'; ?>)</h2>
<h3><?php print_info(substr(get_user_friendly_date($asset_meta['record_date'], '/', false, get_lang(), false), 0, 10)); ?></h3>
<br/><p><?php echo ($type == 'cam') ? 'Click on the following buttons to download the movie in the desired resolution.' : 'Click on the following buttons to download the slide in the desired resolution.'; ?></p>
<a class="close-reveal-modal" href="javascript:close_popup();">&#215;</a>
<br/>
<a href="<?php echo $asset_meta['low_src']; ?>" onclick="server_trace(new Array('3', '<?php echo ($type == 'cam') ? 'cam_download' : 'slide_download'; ?>', current_album, current_asset, duration, 'low'));" class="simple-button">Low resolution</a>
<a href="<?php echo $asset_meta['high_src']; ?>" onclick="server_trace(new Array('3', '<?php echo ($type == 'cam') ? 'cam_download' : 'slide_download'; ?>', current_album, current_asset, duration, 'high'));" class="simple-button">High resolution</a>

