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

include_once 'lib_print.php';
?>
<!-- #side_menu
    Contains the buttons used to navigate through the pages.
    #back_button : displayed on asset page and used to return to the current album
    #home_button : used to return to the home page
-->

<script>
    $('.bookmarks_button, .toc_button, .quiz_button').localScroll({
        target: '#side_pane',
        axis: 'x'
    });

    current_album = '<?php echo $_SESSION['album']; ?>'
    current_asset = '<?php echo $_SESSION['asset']; ?>'

    history.pushState({"url": 'index.php?action=view_asset_details&album=' + current_album + '&asset=' + current_asset + '&asset_token=' + '<?php echo $_SESSION['asset_token']; ?>'}, '', '');

<?php global $show_panel; if ((!isset($personal_bookmarks) || sizeof($personal_bookmarks) == 0) && (!isset($official_bookmarks) || sizeof($official_bookmarks) == 0) && !isset($show_panel)) { $hiden_side = true; ?>
        show_panel = false;
<?php } else { $hiden_side = false; ?>
        show_panel = true;
<?php } if (!acl_user_is_logged() || ((!isset($personal_bookmarks) || sizeof($personal_bookmarks) == 0) && (isset($official_bookmarks) && sizeof($official_bookmarks) != 0))) { ?>
        current_tab = 'toc';
<?php } ?>
    $(document).ready(function () {
        if (current_tab == 'toc') {
            setActivePane('.toc_button');
            $('#side_pane').scrollTo('#asset_toc');
        }else if(current_tab == 'main'){
            setActivePane('.bookmarks_button');
            $('#side_pane').scrollTo('#asset_bookmarks');
        }else{
            setActivePane('.quiz_button');
            $('#side_pane').scrollTo('#asset_quiz');

        }
        if (show_panel) {
            player_bookmarks_panel_show();
        } else {
            player_bookmarks_panel_hide();
        }
    });
    lvl = 3;
    ezplayer_mode = '<?php echo $_SESSION['ezplayer_mode']; ?>';
    is_lecturer = false;
    is_logged = false;
    <?php if (acl_user_is_logged()) { ?>
        is_logged = true;
        <?php if (acl_has_album_moderation($album)) { ?>;
            is_lecturer = true;
        <?php }
    } ?>
</script>

<div id="search">
<?php include_once template_getpath('div_search.php'); ?>
</div>

<div id="side_wrapper" <?php if($hiden_side) { echo 'style="right: -232px;"'; } ?>>
    <div id="side_menu">

        <?php if ($has_bookmark) { ?>
            <div class="bookmarks_button active"><a href="#asset_bookmarks" onclick="setActivePane('.bookmarks_button'); server_trace(new Array('3', 'bookmarks_swap', current_album, current_asset, current_tab));" title="Afficher les signets de l'enregistrement"></a></div>
        <?php } ?>

        <div class='toc_button'><a href="#asset_toc" onclick="setActivePane('.toc_button'); server_trace(new Array('3', 'bookmarks_swap', current_album, current_asset, current_tab));" title="Afficher les signets officiels"></a></div>

        <?php if(in_array($quiz[0]['quizId'],$_SESSION['moodle_courses'])) { ?>
            <div class='quiz_button' ><a href = "#asset_quiz" onclick = "setActivePane('.quiz_button'); server_trace(new Array('3', 'quiz_swap', current_album, current_asset, current_tab));" title = "Afficher les quiz" ></a ></div >
        <?php } ?>
        <div class="settings bookmarks">
            <a class="menu-button" title="Gestion des signets" onclick="$(this).toggleClass('active')" href="javascript:toggle('#bookmarks_actions');"></a>
            <a class="sort-button <?php echo acl_value_get("personal_bm_order"); ?>" title="Inverser l'ordre des signets" href="javascript:bookmarks_sort('personal', '<?php echo (acl_value_get("personal_bm_order") == "chron") ? "reverse_chron" : "chron"; ?>', 'details');"></a>
            <ul id="bookmarks_actions">
                <li><a href="javascript:popup_bookmarks('<?php echo $_SESSION['album']; ?>', '<?php echo $_SESSION['asset']; ?>', 'custom', 'details', 'export')" title="Exporter les signets de l'enregistrement">Exporter les signets</a></li>
                <li><a href="javascript:popup_bookmarks_import();" title="Importer les signets du cours">Importer les signets</a></li>
                <li><a href="javascript:popup_bookmarks('<?php echo $_SESSION['album']; ?>', '<?php echo $_SESSION['asset']; ?>', 'custom', 'details', 'delete')" title="Supprimer les signets liés à cet enregistrement">Supprimer les signets</a></li>
            </ul>
        </div>
        <div class="settings toc">
            <a class="menu-button" title="Gestion des signets officiels" onclick="$(this).toggleClass('active')" href="javascript:toggle('#tocs_actions');"></a>
            <a class="sort-button <?php echo acl_value_get("official_bm_order"); ?>" title="Inverser l'ordre des signets" href="javascript:bookmarks_sort('official', '<?php echo (acl_value_get("official_bm_order") == "chron") ? "reverse_chron" : "chron"; ?>', 'details');"></a>
            <ul id="tocs_actions">
                <li><a href="javascript:popup_bookmarks('<?php echo $_SESSION['album']; ?>', '<?php echo $_SESSION['asset']; ?>', 'official', 'details', 'export')" title="Exporter les signets de l'enregistrement">Exporter les signets</a></li>
                <?php if (acl_user_is_logged() && acl_has_album_moderation($album)) { ?>
                    <li><a href="javascript:popup_bookmarks_import();" title="Importer les signets du cours">Importer les signets</a></li>
                    <li><a href="javascript:popup_bookmarks('<?php echo $_SESSION['album']; ?>', '<?php echo $_SESSION['asset']; ?>', 'official', 'details', 'delete')" title="Supprimer les signets liés à cet enregistrement">Supprimer les signets</a></li>
                <?php } ?>
            </ul>
        </div>

        <!-- TODO : Settings Quiz -->
    </div>


    <!-- #side_pane
        Contains different panes adapted for each view
    the pane displays information about that asset
    -->
    <div id="side_pane">
        <div id="side-pane-scroll-area">

            <?php if ($has_bookmark) { ?>
                <div class="side_pane_content" id="asset_bookmarks">
                    <div class="side_pane_up"><a href="javascript:bookmarks_scroll('down','.bookmark_scroll');"></a></div>
                    <script>var personal_bookmarks_time_code = new Array();</script>
                    <?php if (!isset($personal_bookmarks) || $personal_bookmarks == false || sizeof($personal_bookmarks) == 0) { ?>
                        <div class="no_content">Il n y a aucun signet à afficher.</div>
                    <?php } else { ?>
                        <ul class="bookmark_scroll">
                            <?php foreach ($personal_bookmarks as $index => $bookmark) { ?>
                                <script>personal_bookmarks_time_code.push(<?php echo $bookmark['timecode']; ?>);</script>
                                <li id="bookmark_<?php echo $index; ?>" class="blue level_<?php echo $bookmark['level']; ?>">
                                    <form action="index.php" method="post" id="submit_bookmark_form_<?php echo $index; ?>" onsubmit="return false">

                                        <a class="item blue" href="javascript:player_video_seek(<?php echo $bookmark['timecode'] ?>, '<?php echo (isset($bookmark['type'])) ? $bookmark['type'] : ''; ?>');">
                                            <span class="timecode">
                                                (<?php print_time($bookmark['timecode']); ?>)
                                            </span>
                                            <span id="bookmark<?php echo $index; ?>">
                                                <b><?php print_bookmark_title($bookmark['title']); ?></b>
                                            </span>
                                            <input name="title" id="bookmark_title_<?php echo $index; ?>" type="text" maxlength="70"/>
                                        </a>
                                        <span class="more">
                                            <a class="more-button small" onclick="bookmark_more_toggle('<?php echo $index; ?>', 'bookmark', $(this));"></a>
                                        </span>
                                        <div class="bookmark_detail" id="bookmark_detail_<?php echo $index; ?>">
                                            <div class="bookmark_info" id="bookmark_info_<?php echo $index; ?>">
                                                <div class="blue-title">Description :</div>
                                                <?php print_info($bookmark['description']); ?>
                                                <div class="blue-title" style="margin-top: 6px;">Mots clés : </div>
                                                <?php print_search($bookmark['keywords']); ?>
                                            </div>
                                            <div class="edit_bookmark_form" id="edit_bookmark_<?php echo $index; ?>">
                                                <input type="hidden" name="album" id="bookmark_album_<?php echo $index; ?>" value="<?php echo $bookmark['album']; ?>"/>
                                                <input type="hidden" name="asset" id="bookmark_asset_<?php echo $index; ?>" value="<?php echo $bookmark['asset']; ?>"/>
                                                <input type="hidden" name="source" id="bookmark_source_<?php echo $index; ?>" value="personal"/><br/>
                                                <input type="hidden" name="timecode" id="bookmark_timecode_<?php echo $index; ?>" value="<?php echo $bookmark['timecode']; ?>"/>
                                                <input type="hidden" name="type" id="bookmark_type_<?php echo $index; ?>" value="<?php echo (isset($bookmark['type'])) ? $bookmark['type'] : ''; ?>"/>
                                                <div class="blue-title">Description :</div>
                                                <textarea name="description" id="bookmark_description_<?php echo $index; ?>" style="resize: vertical;" rows="4" ></textarea>
                                                <div class="blue-title" style="margin-top: 6px;">Mots clés : </div>
                                                <input name="keywords" id="bookmark_keywords_<?php echo $index; ?>" type="text"/>
                                                <div class="blue-title" style="margin-top: 6px;">Niveau : </div>
                                                <input type="number" name="level" id="bookmark_level_<?php echo $index; ?>" min="1" max="3" value="1"/>
                                                <!-- Submit button -->
                                                <br/>
                                                <div class="editButtons">
                                                    <a class="button" href="javascript: bookmark_edit_form_toggle('<?php echo $index; ?>', 'bookmark');">Annuler</a>
                                                    <a class="button blue" href="javascript: if(bookmark_edit_form_check('<?php echo $index; ?>', 'bookmark')) bookmark_edit_form_submit('<?php echo $index; ?>', 'bookmark');">Soumettre</a>
                                                </div>
                                                <br />
                                            </div>
                                            <div class="bookmark_options">
                                                <a class="delete-button" title="Supprimer le signet" href="javascript:popup_bookmark('<?php echo $bookmark['album']; ?>', '<?php echo $bookmark['asset']; ?>', '<?php echo $bookmark['timecode']; ?>', 'custom', 'details', 'remove')"></a>
                                                <a class="edit-button" title="Editer le signet" href="javascript:bookmark_edit('<?php echo $index; ?>', 'bookmark', '<?php echo htmlspecialchars(str_replace("'", "\'", $bookmark['title'])) ?>', '<?php echo htmlspecialchars(str_replace(array('"', "'"), array("", "\'"), $bookmark['description'])) ?>', '<?php echo htmlspecialchars(str_replace("'", "\'", $bookmark['keywords'])) ?>', '<?php echo $bookmark['level'] ?>', '<?php echo $bookmark['timecode'] ?>');"></a>
                                                <?php if (acl_user_is_logged() && acl_has_album_moderation($album)) { ?>
                                                    <a class="copy-button" title="Ajouter aux signets officiels"  href="javascript:popup_bookmark('<?php echo $bookmark['album']; ?>', '<?php echo $bookmark['asset']; ?>', '<?php echo $bookmark['timecode']; ?>', 'custom', 'details', 'copy')"></a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </form>
                                </li>
                                <?php if (array_key_exists('timecode', $bookmark) && isset($timecode) && $timecode == $bookmark['timecode']) { ?>
                                    <script>
                                        bookmark_more_toggle('<?php echo $index; ?>', 'bookmark', $("#bookmark_<?php echo $index; ?> .more a"));
                                    </script>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                    <div class="side_pane_down"><a href="javascript:bookmarks_scroll('up','.bookmark_scroll');"></a></div>
                </div>
            <?php } ?>
                <div class="side_pane_content" id="asset_toc">
                    <div class="side_pane_up"><a href="javascript:bookmarks_scroll('down','.toc_scroll');"></a></div>
                    <script>var official_bookmarks_time_code = new Array();</script>
                    <?php if (!isset($official_bookmarks) || $official_bookmarks == false || sizeof($official_bookmarks) == 0) { ?>
                        <div class="no_content">Il n y a pas de signet officiel pour ce cours.</div>
                    <?php } else { ?>
                        <ul class="toc_scroll">
                            <?php foreach ($official_bookmarks as $index => $bookmark) { ?>
                                <script>official_bookmarks_time_code.push(<?php echo $bookmark['timecode']; ?>);</script>
                                <li id="toc_<?php echo $index; ?>" class="orange level_<?php echo $bookmark['level']; ?>">
                                    <form action="index.php" method="post" id="submit_toc_form_<?php echo $index; ?>" onsubmit="return false">
                                    <?php if ($bookmark['asset'] == $asset) { ?>
                                        <a class="item orange" href="javascript:player_video_seek(<?php echo $bookmark['timecode'] ?>, '<?php echo (isset($bookmark['type'])) ? $bookmark['type'] : ''; ?>');">
                                    <?php } else { ?>
                                        <a class="item orange" href="javascript:show_asset_bookmark('<?php echo $bookmark['album']; ?>', '<?php echo $bookmark['asset']; ?>', '<?php echo $bookmark['timecode']; ?>', '<?php echo (isset($bookmark['type'])) ? $bookmark['type'] : ''; ?>')">
                                    <?php } ?>
                                            <span class="timecode orange">(<?php print_time($bookmark['timecode']); ?>) </span>
                                            <span id="toc<?php echo $index; ?>"><b><?php print_bookmark_title($bookmark['title']); ?></b></span>
                                            <input name="title" id="toc_title_<?php echo $index; ?>" type="text" maxlength="70"/>
                                        </a>
                                        <span class="more"><a class="more-button small orange" onclick="bookmark_more_toggle('<?php echo $index; ?>', 'toc', $(this));"></a></span>
                                        <div class="bookmark_detail" id="toc_detail_<?php echo $index; ?>">
                                            <div class="bookmark_info" id="toc_info_<?php echo $index; ?>">
                                                <div class="orange-title">Description :</div>
                                                <?php print_info($bookmark['description']); ?>
                                                <div class="orange-title" style="margin-top: 6px;">Mots clés : </div>
                                                <?php print_search($bookmark['keywords']); ?>
                                            </div>

                                            <div class="edit_bookmark_form" id="edit_toc_<?php echo $index; ?>">
                                                <input type="hidden" name="album" id="toc_album_<?php echo $index; ?>" value="<?php echo $bookmark['album']; ?>"/>
                                                <input type="hidden" name="asset" id="toc_asset_<?php echo $index; ?>" value="<?php echo $bookmark['asset']; ?>"/>
                                                <input type="hidden" name="source" id="toc_source_<?php echo $index; ?>" value="official"/><br/>
                                                <input type="hidden" name="timecode" id="toc_timecode_<?php echo $index; ?>" value="<?php echo $bookmark['timecode']; ?>"/>
                                                <input type="hidden" name="type" id="toc_type_<?php echo $index; ?>" value="<?php echo (isset($bookmark['type'])) ? $bookmark['type'] : ''; ?>"/>
                                                <div class="orange-title">Description :</div>
                                                <textarea name="description" id="toc_description_<?php echo $index; ?>" rows="4" ></textarea>
                                                <div class="orange-title" style="margin-top: 6px;">Mots clés : </div>
                                                <input name="keywords" id="toc_keywords_<?php echo $index; ?>" type="text"/>
                                                <div class="orange-title" style="margin-top: 6px;">Niveau : </div>
                                                <input type="number" name="level" id="toc_level_<?php echo $index; ?>" min="1" max="3" value="1"/>
                                                <!-- Submit button -->
                                                <br/>
                                                <div class="editButtons">
                                                    <a class="button" href="javascript: bookmark_edit_form_toggle('<?php echo $index; ?>', 'toc');">Annuler</a>
                                                    <a class="button orange" href="javascript: if(bookmark_edit_form_check('<?php echo $index; ?>', 'toc')) bookmark_edit_form_submit('<?php echo $index; ?>', 'toc');">Soumettre</a>
                                                </div>
                                                <br />
                                            </div>
                                        <?php if (acl_user_is_logged() && acl_has_album_moderation($album)) { ?>
                                            <div class="bookmark_options">
                                                <a class="delete-button" title="Supprimer le signet" href="javascript:popup_bookmark('<?php echo $bookmark['album']; ?>', '<?php echo $bookmark['asset']; ?>', '<?php echo $bookmark['timecode']; ?>', 'official', 'details', 'remove')"></a>
                                                <a class="edit-button orange" title="Editer le signet" href="javascript:bookmark_edit('<?php echo $index; ?>', 'toc', '<?php echo htmlspecialchars(str_replace("'", "\'", $bookmark['title'])) ?>', '<?php echo htmlspecialchars(str_replace(array('"', "'"), array("", "\'"), $bookmark['description'])) ?>', '<?php echo htmlspecialchars(str_replace("'", "\'", $bookmark['keywords'])) ?>', '<?php echo $bookmark['level'] ?>', '<?php echo $bookmark['timecode'] ?>');"></a>
                                            </div>
                                        <?php } ?>
                                        </div>
                                    </form>
                                </li>
                                <?php if (isset($timecode) && $timecode == $bookmark['timecode']) { ?>
                                    <script>
                                        bookmark_more_toggle('<?php echo $index; ?>', 'toc', $("#toc_<?php echo $index; ?> .more a"));
                                    </script>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                    <div class="side_pane_down"><a href="javascript:bookmarks_scroll('up','.toc_scroll');"></a></div>
                </div>
                <?php if(in_array($quiz[0]['quizId'],$_SESSION['moodle_courses'])) { ?>
                <div class="side_pane_content" id="asset_quiz">
                    <script>
                        var quiz_time_code = new Array();
                        //console.log("$quiz variable");
                        //console.log(<?php echo json_encode($quiz); ?>);
                    </script>
                    <?php if (!isset($quiz) || $quiz == false || sizeof($quiz) == 0 || $quiz === "\n") {  ?>
                        <div class="no_content">Il n y a aucun quiz à afficher.</div>
                    <?php } else { ?>
                        <ul class="quiz_scroll">

                                <li class="rose level_1">
                                    <a class="item rose" style="pointer-events: none; cursor: default;">
                                        <span class="rose-title" id="quiz_title_display"><b><i>Title :</i></b> <?php echo $quiz[0]["title"]; ?></span>
                                    </a>
                                    <span class="more" id="quiz_more"><a class="more-button small rose" onclick="quiz_more_toggle($(this));"></a></span>
                                    <div class="quiz_detail" id="quiz_detail">
                                        <div class="quiz_info" id="quiz_info">
                                            <div class="rose-title">Description :</div>
                                            <?php print_info($quiz[0]['description']); ?>
                                            <div class="rose-title">Feedback :</div>
                                            <?php print_feedback($quiz[0]['feedback']); ?>
                                        </div>

                                        <div class="edit_quiz_form" id="edit_quiz">
                                            <form action="index.php" method="post" id="submit_quiz_form_edit" onsubmit="return false">
                                                <input type="hidden" name="album" id="quiz_album" value="<?php echo $quiz[0]['album']; ?>"/>
                                                <input type="hidden" name="asset" id="quiz_asset" value="<?php echo $quiz[0]['asset']; ?>"/>
                                                <input type="hidden" name="courseId" id="quiz_course_id" value="<?php echo $quiz[0]['courseId']; ?>"/>
                                                <input type="hidden" name="quizId" id="quiz_id" value="<?php echo $quiz[0]['quizId']; ?>"/>
                                                <div class="rose-title">Title:</div>
                                                <input name="title" id="quiz_title_edit" type="text" maxlength="70" value="<?php echo $quiz[0]["title"]; ?>" required/>
                                                <div class="rose-title">Description :</div>
                                                <textarea name="description" id="quiz_description_edit" rows="4" ><?php print_info($quiz[0]['description']); ?></textarea>
                                                <br/>

                                                <?php foreach ($quiz as $index => $question) {  ?>
                                                    <input type="hidden" id="quiz_asset" name="quiz_questionId_Q<?php echo ($index+1); ?>" value="<?php echo $question['questionId']; ?>"/>
                                                    <div class="rose-title">Question <?php echo ($index+1); ?>: </div>
                                                    <input  class="quiz_timecode_edit" id="quiz_timecode_edit_Q<?php echo $index+1; ?>" name="quiz_timecode_<?php echo $index+1; ?>" type="number" value="<?php echo $question['timecode']; ?>" min="1" required/>
                                                    <script> document.getElementById("quiz_timecode_edit_Q<?php echo $index+1; ?>").max = duration; </script>
                                                <?php } ?>

                                                <span class="rose-title">Feedback: <input type="checkbox" name="feedback" id="quiz_feedback_edit" value="1" <?php if($quiz[0]['feedback'] === "1") echo "checked"; ?>></span>

                                                <br/>

                                                <?php // submit button ?>

                                                <div class="editButtons">
                                                    <a class="button" href="javascript: quiz_edit_form_toggle();">Cancel</a>
                                                    <a class="button" href="javascript: if(quiz_form_check('quiz_timecode_edit','quiz_title_edit')){quiz_edit_form_submit();}">Edit</a>
                                                </div>
                                                <br/>
                                            </form>
                                        </div>

                                        <?php if (acl_user_is_logged() && acl_has_album_moderation($album)) { ?>
                                            <div class="quiz_options">
                                                <a class="delete-button" title="Supprimer le quiz" href="javascript:popup_quiz('<?php echo $quiz[0]['album']; ?>', '<?php echo $quiz[0]['asset']; ?>', '<?php echo $quiz[0]['title']; ?>');"></a>
                                                <a class="edit-button rose" title="Editer le quiz" href="javascript:quiz_edit('<?php echo htmlspecialchars(str_replace("'", "\'", $quiz[0]['title'])); ?>','<?php echo htmlspecialchars(str_replace("'", "\'", $quiz[0]['description'])); ?>',quiz_array);"></a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </li>
                            <!--<?php //if (isset($timecode) && $timecode == $bookmark['timecode']) { ?>
                                <script>
                                    bookmark_more_toggle('<?php echo $index; ?>', 'toc', $("#toc_<?php echo $index; ?> .more a"));
                                </script>
                            <?php //} ?>-->
                            <script>if(quiz_array.length > 0) quiz_array = new Array();</script>
                            <?php foreach ($quiz as $index => $question) {  ?>
                                <script>quiz_array.push({courseId:<?php echo $question['courseId']; ?>,quizId:<?php echo $question['quizId']; ?>,questionId:<?php echo $question['questionId']; ?>,timecode:<?php echo $question['timecode']; ?>,feedback:<?php echo $question['feedback']; ?>,done:false});</script>
                                <script>quiz_time_code.push(<?php echo $question['timecode']; ?>);</script>
                                <li id="question_<?php echo $index; ?>" class="rose level_3">
                                    <div class="question_display">
                                    <a class="item rose" href="javascript:player_video_seek(<?php echo $question['timecode']; ?>, '');">
                                        <span class="timecode rose">(<?php print_time($question['timecode']); ?>) </span>
                                        <span id="question<?php echo $index; ?>"><b><?php $indexQ = $index+1; echo "Question ".$indexQ; ?></b></span>
                                        <input name="title" id="question_title_<?php echo $index; ?>" type="text" maxlength="70"/>
                                    </a>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </div>
                <?php } ?>
                <!-- end quiz tab -->
        </div>
    </div>
</div>
<script>
    $(window).trigger('resize');
</script>
