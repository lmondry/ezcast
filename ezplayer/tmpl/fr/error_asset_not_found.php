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

<div class="error_message">
    Accès refusé: enregistrement inexistant

    <?php
    if (acl_has_album_permissions($album)
            && user_prefs_asset_bookmarks_list_get($_SESSION['user_login'], $album, $error_asset)) {
        ?>
        <div style="margin-top: 18px;">
            Cet enregistrement n'existe plus mais il est toujours affiché parmi vos signets. Souhaitez-vous:
            <form action="index.php?action=bookmarks_asset_export" method="post" name="export_asset_bookmarks_form" onsubmit="return false">
                <input type="hidden" name="album" value="<?php echo $album; ?>"/>
                <input type="hidden" name="asset" value="<?php echo $asset; ?>"/>
            </form>
            <br/><br/>
            <a class="button" style="width:300px;" href="javascript: bookmarks_delete_all('<?php echo $album; ?>', '<?php echo $asset; ?>');">Supprimer les signets liés à cet enregistrement</a>
            <a class="button" style="width:300px;" href="#" onclick="document.export_asset_bookmarks_form.submit(); return false;">Exporter les signets de l'enregistrement</a>
        </div>
<?php } ?>
    <div style="margin-top: 18px;">
        <a class="button" style="width:250px;" href="index.php">Retour à l'accueil</a>
    </div>
</div>