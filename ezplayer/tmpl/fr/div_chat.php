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

<div id="chat">
    <div id="chat_header">
        <span id="chat_logo"></span>
        <span>Messagerie instantanée</span>
    </div>
    <div id="chat_menu">
        <ul>
            <li><a id='chat_text_button' href="#chat_text" title="Messagerie instantanée" class="active"><span>Messages</span></a></li>
            <li><a id='chat_questions_button' title="Liste des questions" href="#chat_questions"><span>#questions</span></a></li>
            <li><a id='chat_help_button' title="Aide pour le chat" href="#chat_help"><span>Aide</span></a></li>
        </ul>
    </div>
    <div id="chat_wrapper">
        <div id="chat_scrollable_area">
            <div id='chat_help'>

                <div class="chat_ad">
                    Voici les possibilités du chat
                </div>
                <ul>
                    <li><span><b>Date et heure</b></span> Cliquez sur un message pour afficher la date et l'heure de publication</li>
                    <li><span><b>Référencement</b></span> Utilisez le hashtag <b>#question</b> pour référencer votre question dans une liste qui pourra être rapidement consultée par votre professeur</li>
                    <li><span><b>Liens web (URL)</b></span> Insérez des liens web dans vos messages Les URL sont automatiquement reconnues lorsqu'elles commencent par www ou http://. Pour créer d'autres liens ou alias, utilisez les astérisques:  <b>**www.monlien.be**</b> ou <b>**www.monlien.be mon alias de lien**</b></li>
                </ul>
            </div>
            <div id="chat_questions">
                <div class="chat_ad">
                    Liste des questions posées par les utilisateurs du chat
                </div>
                <div id='chat_qst_container'>

                </div>
            </div>
            <div id="chat_text" >
                <div id="chat_messages">
                    <?php include_once template_getpath("div_chat_messages.php"); ?>
                </div>    
                <div class="chat_ad">
                    Utilisez le hashtag <a href='javascript:chat_question_add();'>#question</a> pour poser votre question au professeur
                </div>
                <form action="index.php" method="post" id="submit_chat_form" onsubmit="return false;">        
                    <input type="hidden" name="chat_album" id="chat_album" value="<?php echo $album; ?>"/>  
                    <input type="hidden" name="chat_asset" id="chat_asset" value="<?php echo $asset; ?>"/>
                    <input type="hidden" name="chat_timecode" id="chat_timecode" value=""/>
                    <textarea placeholder="Votre message" name="chat_message" id="chat_message"></textarea>
                </form>
                <div class="chat_button">
                    <a class="button" href="javascript: if(chat_form_check()) chat_form_submit();"><span>Envoyer</span></a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#chat_message').keydown(function (e) {
        if (e.keyCode == 13) {
            if (!e.shiftKey) {
                e.preventDefault();
                if (chat_form_check()) {
                    chat_form_submit();
                }
            }
        }
    });

    // #chat_menu must exist before calling this 
    // (therefor, scripts are placed at the bottom of the page)
    $('#chat_menu').localScroll({
        target: '#chat_wrapper',
        axis: 'x',
        duration: 500
    });

    $('#chat_menu ul li a').click(function () {
        $('#chat_menu ul li a').removeClass('active');
        $(this).addClass('active');
        current_chat_panel = $(this).attr('href');
    });
</script>