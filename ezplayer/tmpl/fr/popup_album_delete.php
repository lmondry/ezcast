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

<h2><b style="text-transform:uppercase;"><?php echo suffix_remove($album['album']); ?></b></h2>
<h3><?php echo $album['title']; ?></h3>
<br/><p><strong>Attention</strong>, vous vous apprêtez à supprimer un <strong>cours</strong> et <strong>tous les signets</strong> qu'il contient. Cette opération est <strong>irréversible</strong>. Si vous souhaitez malgré tout conserver les signets, assurez vous de les avoir exportés au préalable.</p>
<a class="close-reveal-modal" href="javascript:close_popup();">&#215;</a>
<br/>
<a href="javascript:album_token_delete('<?php echo $album['album']; ?>');" class="delete-button-confirm">Supprimer</a>
<a class="close-reveal-modal-button" href="javascript:close_popup();">Annuler</a>

