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
DEPRECATED

Pops up for resetting RSS feed
You should not have to include this file yourself.
-->
<div class="popup" id="popup_reset_rss_feed">
    <h2>Régénérer RSS?</h2>
    <span class="warning"><strong>Attention : </strong>opération non-réversible.</span><br/><br/>
    <div>Le flux RSS va être régénéré. Les personnes abonnées à ce flux RSS ne pourront plus y accéder.</div><br/>
     <span class="Bouton"><a href="?action=view_help" target="_blank"><span>Aide</span></a></span>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     <span class="Bouton"><a href="javascript:close_popup();"><span>Annuler</span></a></span>
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     <span class="Bouton"><a href="javascript:popup_regenerate_rss_callback('<?php echo $album; ?>');"><span>OK</span></a></span>
</div>