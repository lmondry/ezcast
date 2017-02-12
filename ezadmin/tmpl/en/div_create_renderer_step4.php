
<script>
    function swap(div_a, div_b) {
        document.getElementById(div_a).style.display = 'block';
        document.getElementById(div_b).style.display = 'none';
    }
    swap('main_step_4', 'load_step_4');

    var save_step = 1;
    var numSteps = 3;
    function loadStepAjax(step) {
        save_step = step;
        $.ajax('index.php?action=create_renderer', {
            type: 'POST',
            dataType: 'json',
            data: "renderer_step=4&installation_step=" + step,
            success: function(response) {
                if (response.error === true){
                    $('#loading_img').hide();
                    $('#main_step_4_failed').show();
                    $('#load_step_4').append(response.msg);
                } else {
                    $('#main_step_4_failed').hide();
                    $('#load_step_4').append(response);
                    if (step < 3) {
                        loadStepAjax(step + 1);
                    } else {
                        $('#loading_img').hide();
                        $('#next_step').show();
                    }
                }
            }
        });
    }
</script>

<div class="page_title">Create renderer > Installation</div>

<div id="main_step_4">
    <form method="POST" class="form-horizontal">

        <?php if ($error) { ?>
            <div class="alert alert-danger"><?php echo $error ?></div>
        <?php } ?>
        <?php if (isset($tests_success) && $tests_success) { ?>
            <div class="alert alert-success">Configuration tests on the remote server (renderer) have been successful !</div>
        <?php } ?>
        <input type="hidden" name="renderer_step" value="4"/>

        The program is now going to: <br/><br/>
        <ul>
            <li>Copy EZrenderer installation files on the remote server 
            [<?php echo $_SESSION['renderer_root_path'];?>]</li>
            <li>Install EZrenderer on the remote server (renderer) </li>
            <li>Update renderers list for EZadmin and EZmanager </li>
        </ul>

        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="submit_step_4_prev" value="Previous"/>
            <input type="button" class="btn btn-primary" name="submit_step_4_next" onclick="swap('load_step_4', 'main_step_4');
        loadStepAjax(1)" value="Next"/>
        </div>
    </form>
</div>

<div id="load_step_4" style="text-align:center; display: none">
    <br/>
    <img id="loading_img" src="img/loading_white.gif"/>
    <br/><br/>
    Copying EZrenderer installation files ...
</div>

<div id="next_step" style="display: none">
    <br/><br/>    
    <form method="POST" class="form-horizontal">
        <input type="hidden" name="renderer_step" value="5"/>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="finish_install" value="Finish"/>
        </div>
    </form>
</div>

<div id="main_step_4_failed" style="display: none">
    <br/><br/>    
    <form method="POST" class="form-horizontal">
        <input type="hidden" name="renderer_step" value="5"/>
        <div class="form-group">
            <input type="button" class="btn btn-primary" onclick="swap('loading_img', 'main_step_4');loadStepAjax(save_step)" value="Retry"/>
        </div>
    </form>
</div>