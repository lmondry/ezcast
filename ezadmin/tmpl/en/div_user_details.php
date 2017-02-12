
<?php if ($userinfo) { ?>
    <div class="page_title">User information: <?php echo $user_ID; ?></div>
    
    <div class="col-md-8">
        <form class="form-horizontal" method="POST">

            <?php if(isset($error)) { ?>
                <div class="alert alert-danger alert-dismissible fade in" role="alert"> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span></button> 
                    <?php echo $error; ?>
                </div>
            <?php } ?>

            <input type="hidden" name="post"/>

            <!-- User name -->
            <div class="form-group">
                <label class="col-md-3 control-label">Username</label>
                <div class="col-sm-8">
                    <?php if ($origin == 'internal') { ?>
                        <p class="view form-control-static">
                            <?php echo $forename . ' ' . $surname; ?>
                        </p>
                        <div class="edit form-inline" style="display: inline-block;">
                            <input type="text" class="form-control" style="width: 49%" name="forename" 
                                   value="<?php echo htmlspecialchars($forename) ?>" placeholder="Forename"/>
                            <input type="text" class="form-control" style="width: 49%" name="surname" 
                                   value="<?php echo htmlspecialchars($surname) ?>" placeholder="Surname"/>
                        </div>
                    <?php } else { ?>
                        <p class="view form-control-static">
                            <?php echo $forename . ' ' . $surname; ?>
                        </p>
                        <input type="hidden" name="forename" value="<?php echo htmlspecialchars($forename) ?>"/>
                        <input type="hidden" name="surname" value="<?php echo htmlspecialchars($surname) ?>"/>
                    <?php } ?>
                </div>
            </div>

            <!-- Origin -->
            <div class="form-group">
                <label class="col-md-3 control-label">Origin</label>
                <div class="col-sm-5">
                    <span class="label 
                        <?php if($origin == 'internal') { 
                            echo 'label-info'; 
                        } else if($origin == 'external') { 
                            echo 'label-primary'; 
                        } else {
                            echo 'label-danger';
                        } ?>
                        ">
                        <?php 
                        if($origin == 'internal') {
                            echo 'Internal';
                        } else if($origin == 'external') {
                            echo 'External';
                        } else {
                            echo 'Error';
                        } ?>
                    </span>
                </div>
            </div>

            <!-- Is EZcast admin -->
            <div class="form-group">
                <label class="col-md-3 control-label">Admin</label>
                <p class="view form-control-static">
                    <?php if ($is_admin) { ?>
                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Yes
                    <?php } else { ?>
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> No
                    <?php } ?>
                </p>
                <div class="col-md-8">
                    <label class="edit">
                        <input type="checkbox" name="permissions" <?php echo $is_admin ? 'checked' : '' ?> />
                    </label>
                </div>
            </div>

            <!-- Is EZadmin admin -->
            <div class="form-group">
                <label class="col-md-3 control-label">Can access EZadmin</label>
                <p class="view form-control-static">
                    <?php if ($is_ezadmin) { ?>
                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Yes
                    <?php } else { ?>
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> No
                    <?php } ?>
                </p>
                <div class="col-md-8">
                    <label class="edit">
                        <input type="checkbox" name="is_ezadmin" <?php echo $is_ezadmin ? "checked" : '' ?> />
                    </label>
                </div>
            </div>

            <!-- In recorders -->
            <div class="form-group">
                <label class="col-md-3 control-label">In classroom</label>
                <p class="form-control-static">
                    <?php if ($in_classroom) { ?>
                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Yes
                    <?php } else { ?>
                        <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> No
                    <?php } ?>
                </p>
            </div>

            
            <?php if ($passNotSet) { ?>
                <div class="alert alert-danger alert-dismissible fade in" role="alert"> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span></button> 
                    No password defined
                </div>
            <?php } ?>

            <!-- recorder passwd -->
            <div class="edit form-group">
                <label class="col-md-3 control-label">Recorder password</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" name="recorder_passwd" 
                           placeholder="password"/>
                    <span id="helpBlock" class="help-block">Leave empty field to keep the previous password</span>
                </div>
            </div>
        </form>
    </div>

    
    <!-- Button to edit or remove user -->
    <div class="col-md-2 col-md-offset-2">
        <form action="index.php?action=remove_user" method="POST" style="margin:0px;">
            <input type="hidden" name="user_ID" value="<?php echo $user_ID; ?>" />

            <button type="button" class="btn btn-block btn-primary edit_mode">Edit</button>
            <button type="button" class="btn btn-block edit_cancel">Cancel</button>

            <?php if($origin == 'internal') { ?>
                <button type="submit" name="delete" value="Delete" onClick="confirm('Are you sure you want to delete this item ?')" class="btn btn-block btn-danger delete_button"/>
                Delete
                </button>
            <?php } ?>
        </form>
    </div>

    <table class="table table-striped table-bordered table-hover courses_table">
        <thead>
            <tr>
                <th>Course code</th>
                <th>Course name</th>
                <th>Link origin</th>
                <th>In classroom</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($courses as $c) { ?>
                <tr data-id="<?php echo $c['ID'] ?>" data-origin="<?php echo $u['origin'] ?>">
                    <td><?php echo $c['course_code']; ?></td>
                    <td><?php echo $c['course_name']; ?></td>
                    <td>
                        <span class="label <?php if ($c['origin'] == 'internal') echo 'label-info'; ?>"><?php
                            if ($c['origin'] == 'internal')
                                echo 'Internal';
                            else
                                echo 'External';
                            ?>
                        </span>
                    </td>
                    <td><?php echo $c['in_recorders'] ? '<span class="glyphicon glyphicon-ok"></span> Yes' : '<span class="glyphicon glyphicon-remove"></span> No'; ?></td>
                    <td class="unlink" style="cursor: pointer;"><?php if ($c['origin'] == 'internal') echo '<span class="glyphicon glyphicon-remove"></span> Remove link'; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="create_link form-inline text-center">
            <input type="text" class="form-control" name="link_to" value="" class="input-medium" placeholder="Course code" data-provide="typeahead" autocomplete="off" />
            <button name="link" class="btn btn-primary">Add user</button>
    </div>



    <script>
    $(function() {
        $('.edit_cancel').hide();
        $('.edit').hide();
        $("button.edit_cancel").click(function() {
            $this = $(this);
            $this.hide();
            $('.edit_mode').addClass('btn-primary');
            $('.edit_mode').removeClass('btn-success');
            $('.edit_mode').removeClass('active_edit_mode'); // remove edit mode
            $('.edit_mode').text("Edit");
            $('.delete_button').show();
            $(".edit").hide();
            $('.view').show();

        });

        $("button.edit_mode").click(function() {
            $this = $(this);
            $('.edit_cancel').show();
            $('.delete_button').hide();

            if ($this.hasClass("active_edit_mode")) {
                $("form").first().submit();
            } else {
                $this.addClass('active_edit_mode'); // Add edit mode
                $('.edit_mode').removeClass('btn-primary');
                $('.edit_mode').addClass('btn-success');
                $('.edit_mode').text("Submit");
                $(".edit").show();
                $('.view').hide();
            }
        });


        $(".courses_table .unlink").click(function() {
            $this = $(this);

            if ($this.parent().data('origin') == 'external')
                alert("You cannot delete a external link.");
            if (!confirm("Are you sure you want to delete this link?"))
                return false;

            var link = $this.parent().data("id");

            $.ajax("index.php?action=link_unlink_course_user&user_ID=<?php echo $input['user_ID'] ?>", {
                type: "post",
                data: {
                    query: "unlink",
                    id: link
                },
                success: function(jqXHR, textStatus) {
                    var data = JSON.parse(jqXHR);

                    if (data.error) {
                        if (data.error == 1)
                            alert("You cannot delete a external link.");
                        return;
                    }

                    $this.parent().hide(400, function() {
                        $(this).remove();
                    });
                }
            });
        });

        $(".create_link button[name='link']").click(function() {
            $this = $(this);

            var user = $this.prev().val();
            $this.prev().val('');

            $.ajax("index.php?action=link_unlink_course_user&user_ID=<?php echo $input['user_ID'] ?>", {
                type: "post",
                data: {
                    query: "link",
                    id: user
                },
                success: function(jqXHR, textStatus) {
                    var data = JSON.parse(jqXHR);

                    if (data.error) {
                        if (data.error == '1')
                            alert("Unknown user or already present.");
                        return;
                    }

                    var $course_code = $('<td></td>').text(data.course_code);
                    var $course_name = $('<td></td>').text(data.course_name);
                    var $delete = $('<td class="unlink" style="cursor:pointer;"><span class="glyphicon glyphicon-remove"></span>Remove link</td>');

                    var $tr = $('<tr data-id="' + data.id + '"></tr>');
                    $tr.append($course_code);
                    $tr.append($course_name);
                    $tr.append($delete);

                    $tr.hide();

                    $('.courses_table tbody').append($tr);

                    $tr.show(400).css('display', 'table-row');
                }
            });
        });
    });
    </script>

<?php } else { ?>

    <em><?php echo $input['user_ID'] ?></em> is not a valid user. Try again.

<?php } ?>


