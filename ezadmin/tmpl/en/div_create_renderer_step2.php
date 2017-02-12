
<script>
function swap(div_a, div_b) {
    document.getElementById(div_a).style.display = 'block';
    document.getElementById(div_b).style.display = 'none';
}
swap('main_step_2', 'load_step_2')
</script>

<div class="page_title">Create renderer > SSH configuration</div>

<div id="main_step_2">
    <form method="POST" class="form-horizontal">

        <?php if(isset($error)) { ?>
            <div class="alert alert-danger alert-dismissible fade in" role="alert"> 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span></button> 
                <?php echo $error; ?>
            </div>
        <?php } ?>
            
        <input type="hidden" name="renderer_step" value="2"/>
        Add the following <b>public key</b> in 
            <b>~<?php echo $_SESSION['renderer_user'];?>/.ssh/authorized_keys</b>on the remote server (renderer) 
            and click "Continue" to test the SSH connection. 
        <br/>(<?php echo $_SESSION['renderer_address'];?>)
        <br/><br/>
        <textarea readonly readonly="true" class="form-control no_resize" style="width: 780px; height: 180px;" rows="14" cols="170">
            <?php echo $ssh_public_key; ?>
        </textarea>
        <br />

        <div class="form-group text-center">
            <input type="submit" class="btn btn-primary" name="submit_step_2_prev" value="Previous"/>
            <input type="submit" class="btn btn-primary" name="submit_step_2_next" onclick="swap('load_step_2','main_step_2');" value="Next"/>
        </div>
    </form>
</div>

<div id="load_step_2" style="text-align:center; display: none">
    <br/><br/>
    Checking SSH connection to the remote server (renderer) (<?php echo $_SESSION['renderer_address'];?>).
    <br/>This may last up to <?php echo $ssh_timeout;?> seconds. Please, 
            do not refresh the page.
    <br/><br/><br/>
    <img src="img/loading_white.gif"/>
</div>