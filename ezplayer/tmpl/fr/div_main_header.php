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

<?php if(!isset($_COOKIE['infos_cookie'])) { ?>
    <div class="cookie_header">
        Notre site utilise des cookies pour améliorer votre expérience. 
            En continuant à naviguer sur notre site, vous acceptez leur utilisation.
        <button onclick="document.cookie='infos_cookie=true';$('.cookie_header').hide()">OK</button>
    </div>
<?php } ?>


<script>
    settings_form = false;
    contact_form = false;
</script>
<div class="header">
    <div class="header_content">
        <div class="logo"> 
            <?php if (file_exists('./htdocs/images/Header/organization-logo.png')) { ?>
                <a href="<?php
                global $organization_url;
                echo $organization_url;
                ?>"><img src="./images/Header/organization-logo.png"/></a>
<?php } ?>
            <a href="index.php" title="Retour à l'accueil"><img src="./images/Header/LogoEZplayer.png" alt="" /></a>
        </div>
        <!-- S E T T I N G S -->
        <div class="form" id="settings_form">
            <div id='settings_form_wrapper'>
<?php include_once template_getpath('div_settings.php'); ?>
            </div>
        </div>

        <!-- C O N T A C T -->
        <div class="form" id="contact_form">
            <div id='contact_form_wrapper'>
<?php include_once template_getpath('div_contact.php'); ?>
            </div>
        </div>

        <?php if (acl_user_is_logged()) { ?>
            <a href="index.php?action=logout" title="Déconnexion de EZplayer"><span class="logout">Déconnexion</span></a>
            <?php
        } else {
            require_once template_getpath('popup_login.php');
            ?>
            <a onclick="javascript:$('#popup_login').reveal($(this).data());" title="Connexion à EZplayer"><span class="logout">Connexion</span></a>
<?php } ?>       
        <span style="float: right; margin: 1px 3px; font-size: 15px;">|</span>
        <a href="index.php?action=view_help" target="_blank" title="Aide à l'utilisation d'EZplayer"><span class="logout green">Aide</span></a>
        <a id="help" href="index.php?action=view_help" target="_blank" title="Aide à l'utilisation d'EZplayer"></a>
        <span style="float: right; margin: 1px 3px; font-size: 15px;">|</span>
<?php if (acl_user_is_logged()) { ?>
            <a id="contact" onclick="javascript:header_form_toggle('contact')" title="Nous signaler un problème"></a>  
            <a id="user-settings" class="pull-right" onclick="javascript:header_form_toggle('settings')" title="Afficher les préférences">
                <span>Préférences</span> 
            </a>      
        <?php } ?>
<?php if (acl_admin_user()) { ?>
            <span style="float: right; margin: 1px 3px; font-size: 15px;">|</span>
            <a href="javascript:admin_mode_update()" title="Activer/désactiver le mode Admin">
                <span class="logout"><?php echo acl_is_admin() ? 'Mode admin activé ' : 'Mode admin désactivé '; ?></span>
            </a>

        <?php } ?>
<?php if (acl_runas()) { ?>
            <span style="float: right; margin: 1px 3px; font-size: 15px;">|</span>
            <span class="logout">Connecté en tant que  <b><?php echo $_SESSION['user_full_name']; ?></b></span>
<?php } ?>
    </div>
</div>
<?php if (!acl_user_is_logged() && isset($login_error) && !empty($login_error)) { ?>
    <script>              $('#popup_login').reveal($(this).data());</script> 
<?php } ?>