<?php 
/*
* EZCAST EZmanager 
*
* Copyright (C) 2016 Université libre de Bruxelles
*
* Written by Michel Jansens <mjansens@ulb.ac.be>
* 		    Arnaud Wijns <awijns@ulb.ac.be>
*                   Antoine Dewilde
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


<!-- 
This is the popup displaying the URL to the media.
You should not have to use this file on your own; if you do, make sure the variable $media_url and $media_url_web are defined
-->
<?php if(isset($media_url)) { ?>
<div class="popup" id="popup_media_URL">
    <h2>Video</h2>
    You can watch or distribute this video by using the following link: <br/><br/>
    <strong><a href="<?php echo $media_url; ?>"><?php echo $media_url; ?></a></strong><br/><br/>
    
    <!-- Copy to clipboard button
    All browsers use flash + javascript except Internet explorer which has an access to the clipboard -->
    
    <!--[if !IE]><!-->
    <div id="wrapper_clip" style="position:relative">
        <span id="copy_button" class="Bouton"><a><span id="copy_button_text">Copy to clipboard</span></a></span>
        <div id="zero_clipboard" onmouseout="getElementById('copy_button_text').style.color='#797676'" onmouseover="getElementById('copy_button_text').style.color='#004B93'" style="position:absolute; left:300px; top:0px; width:200px; height:30px; z-index:99"></div>
    </div>    
    <!--<![endif]--> 
    
    <!--[if IE]>
    <span id="copy_button" class="Bouton"><a href="#" onclick="window.clipboardData.setData('Text','<?php echo $media_url_web; ?>');"><span>Copy to clipboard</span></a></span>
    <![endif]-->
</div>


<script>
    // This code allows to copy the ulb_code in the user's clipboard when the user clicks on the button
    copyToClipboard("#zero_clipboard", "<?php echo $media_url_web; ?>");
</script>
<?php } ?>