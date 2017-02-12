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
Asks confirmation before deleting an album.
You should not have to include this file yourself (included in div_album_header.php), but if you do, make sure that $album_name is correctly defined
-->
<div class="popup" id="popup_delete_album">
    <h2>Supprimer l'album <?php echo $album_name; ?>?</h2>
    <span class="warning"><strong>Attention : </strong>opération destructive non-réversible.<br/><br/></span>
    <div><strong>Attention : </strong>vous vous apprêtez à supprimer l'album <?php echo $album_name; ?>. En faisant ainsi, vous supprimerez définitivement l'<strong>album public</strong> <i>et</i> l'<strong>album privé</strong> de ce cours, ainsi que tout leur contenu. Les autres titulaires de l'album n'y auront plus accès non plus</div><br/>
    
    <span class="Bouton"> <a href="?action=view_help" target="_blank"><span>Aide</span></a></span>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <span class="Bouton"> <a href="javascript:close_popup();"><span>Annuler</span></a></span>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <span class="Bouton"> <a href="javascript:show_popup_from_outer_div('index.php?action=delete_album&amp;album=<?php echo $album_name; ?>', true);"><span>OK</span></a></span>
</div>