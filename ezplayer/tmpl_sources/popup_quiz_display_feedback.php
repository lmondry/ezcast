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

<div class="que"><div class="congrats"><h1>®Quiz_finish_congrats®</h1></div></div>
<br>

<?php
$str = <<<HTML_CODE
    $generalFeedbackHTML;
HTML_CODE;
?>

<div class="que"><div class="inform"><h3><?php echo $generalFeedbackHTML; ?></h3></div></div>

<?php
$str = <<<HTML_CODE
    $correction_html 
HTML_CODE;

$str = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $str);
echo $str;
?>

<div>
<a class="close-reveal-modal" href="javascript:cancel_question();">&#215;</a>
<br/>
<a class="close-reveal-modal-button"  href="javascript:cancel_question();">®Close®</a>
</div>