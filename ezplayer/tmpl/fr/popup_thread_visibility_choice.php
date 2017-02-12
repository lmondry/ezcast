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

<h3>Visibilité de la discussion</h3><br/>
<span>Vous pouvez choisir la visibilité pour votre discussion: </span>
<br/><br/>
<ul style="list-style: none;">
    <li style="padding-bottom: 6px;"><div class="orange-title">Etudiants + professeurs: </div>Tout le monde peut voir votre discussion. Votre professeur aura la possibilité de vous répondre.</li>
    <li style="padding-bottom: 6px;"><div class="blue-title">Etudiants: </div>Seuls les étudiants pourront voir votre discussion</li>
</ul>
<br/><br/>
<a class="close-reveal-modal-button button orange" href="javascript:thread_visibility_choose(0)" style="width: 250px;">Etudiants + professeurs</a>
<a class="close-reveal-modal-button button green2" href="javascript:thread_visibility_choose(1)" style="width: 250px;">Etudiants</a>
<a class="close-reveal-modal" href="javascript:close_popup();">&#215;</a>
