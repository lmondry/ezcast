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

<h2><b style="text-transform:uppercase;">Question <?php echo ($question_id+1); ?></b></h2>
<br/>

<?php
$str = <<<HTML_CODE
    $question_html 
HTML_CODE;

$str = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $str);
echo $str;
?>

<div>
<a class="close-reveal-modal" href="javascript:cancel_question();">&#215;</a>
<br/>
<a href="javascript:submit_question(<?php echo ($question_id); ?>,quiz_array[<?php echo ($question_id); ?>].attemptid);" class="delete-button-confirm">Répondre</a>
<a class="close-reveal-modal-button"  href="javascript:cancel_question();">Annuler</a>
</div>