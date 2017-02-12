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
<h2>Un problème ? Une suggestion ?</h2>
<br/>
<p>Utilisez le formulaire suivant pour entrer en contact avec nous. Pensez à renseigner votre adresse email si vous souhaitez une réponse de notre part.</p>
<br/>

<form name="submit_contact_form" action="<?php
global $ezplayer_safe_url;
echo $ezplayer_safe_url;
?>/index.php" method="post">
    <input type="hidden" name="action" value="contact_send" />

    <!-- Title field -->  
    <div style='clear: both'>
        <label>Adresse email&nbsp;:
            <span class="small">Facultatif</span>
        </label>
        <input name="email" tabindex='11' id="contact_email" type="text" maxlength="70"/>
    </div>


    <!-- keywords field -->
    <div style='clear: both'>
        <label>Sujet&nbsp;:
        </label>
        <select name='subject'>
            <option value="Album manquant">Album manquant</option>
            <option value="Enregistrement manquant">Enregistrement manquant</option>
            <option value="Vidéo sans son">Vidéo sans son</option>
            <option value="Problème de lecture vidéo">Problème de lecture vidéo</option>
            <option value="Problème lié aux discussions">Problème lié aux discussions</option>
            <option value="Problème lié aux signets">Problème lié aux signets</option>
            <option value="Signaler un bug">Signaler un bug</option>
            <option value="Demander de l'aide">Demander de l'aide</option>
            <option value="Proposer une amélioration">Proposer une amélioration</option>
            <option value="Autre">Autre</option>
        </select>
    </div>

    <!-- Description field -->
    <div style='clear: both'>
        <label>Message&nbsp;:
            <span class="small">Obligatoire</span>
        </label>
        <textarea name="message" tabindex='12' id="contact_message" rows="4" ></textarea>
    </div>

    <div style='clear: both; margin-left: 130px;'>
        <a class="button-empty green" href="javascript: header_form_hide('contact');">Annuler</a>
        <a class="button green" href="#" onclick="document.submit_contact_form.submit();">Envoyer</a>
    </div>

</form>
