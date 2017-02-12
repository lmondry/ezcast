    
<script>
    function swap(div_a, div_b) {
        document.getElementById(div_a).style.display = 'block';
        document.getElementById(div_b).style.display = 'none';
    }
    swap('main_step_2', 'load_step_2');
    
    function select_option(){
        var options_list = document.getElementById('options'); 
        var SelIndex = options_list.selectedIndex; 
        var SelValue = options_list.options[SelIndex].value; 
        
        $('.renderer_option').hide();
        $('.' + SelValue).show();
    }
    
</script>
    
<div class="page_title">Créer renderer > Informations supplémentaires</div>
<div id="main_step_3">
    
    <form method="POST" class="form-horizontal">
        
    <?php if(isset($error)) { ?>
        <div class="alert alert-danger alert-dismissible fade in" role="alert"> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span></button> 
            <?php echo $error; ?>
        </div>
    <?php } else { ?>
        <div class="alert alert-success">Connexion SSH au serveur distant (renderer) réussie !</div>
    <?php } ?>
        
        <input type="hidden" name="renderer_step" value="3"/>
            
        <div class="form-group">
            <label for="renderer_root_path" class="col-md-2 control-label">Racine EZrenderer</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="renderer_root_path" value="<?php echo $input['renderer_root_path']?>"/>
            </div>
        </div>
            
        <div class="form-group">
            <label for="renderer_php" class="col-md-2 control-label">PHP (cli)</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="renderer_php" value="<?php echo $input['renderer_php']?>"/>
            </div>
        </div>
            
        <div class="form-group">
            <label for="renderer_options" class="col-md-2 control-label">Encoder program</label>
            <div class="col-sm-5">
                <select class="selectpicker form-control" id="options" name="renderer_options" onchange="select_option();">
                <?php 
                foreach ($renderers_options as $option_name => $option){
                    if ($option_name != 'ffmpeg_exp' || 
                            (isset($display_ffmpeg_exp) && $display_ffmpeg_exp)) {
                        
                        echo '<option value="' . $option_name . '"';
                        if(isset($input) && array_key_exists('renderer_options', $input) &&
                                $option_name == $input['renderer_options']) {
                            echo ' selected ';
                        }
                        echo '>'.$option['description'] . '</option>';
                    }
                }
                ?>
                </select>
            </div>
        </div>
            
        <div class="renderer_option ffmpeg ffmpeg_exp">
            <div class="form-group">
                <label for="renderer_ffmpeg" class="col-md-2 control-label">FFMPEG path</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="renderer_ffmpeg" value="<?php echo $input['renderer_ffmpeg']?>"/>
                </div>
            </div>
                
            <div class="form-group">
                <label for="renderer_ffprobe" class="col-md-2 control-label">FFPROBE path</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="renderer_ffprobe" value="<?php echo $input['renderer_ffprobe']?>"/>
                </div>
            </div>
        </div>
            
        <div class="form-group">
            <div class="renderer_option avconv" style="display:none">
                <label for="renderer_avconv" class="col-md-2 control-label">AVCONV path</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="renderer_avconv" value="<?php echo $input['renderer_avconv']?>"/>
                </div>
            </div>
        </div>
            
        <div class="form-group">
            <label for="renderer_num_jobs" class="col-md-2 control-label">Jobs</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="renderer_num_jobs" value="<?php echo $input['renderer_num_jobs']?>"/>
            </div>
        </div>
            
        <div class="form-group">
            <label for="renderer_num_threads" class="col-md-2 control-label">Threads/job</label>
            <div class="col-sm-5">
                <input type="text" class="form-control" name="renderer_num_threads" value="<?php echo $input['renderer_num_threads']?>"/>
            </div>
        </div>
        <br />
        <div class="form-group text-center">
            <input type="submit" class="btn btn-primary" name="submit_step_3_prev" value="Précédent"/>
            <input type="submit" class="btn btn-primary" name="submit_step_3_next" onclick="swap('load_step_3','main_step_3');" value="Suivant"/>
            <input type="submit" class="btn btn-warning" name="submit_step_3_skip" value="Ignorer les tests"/>
        </div>
    </form>
</div>

<div id="load_step_3" style="text-align:center; display: none">
    <br/><br/>
    Vérification de la configuration du serveur distant (renderer) (<?php echo $_SESSION['renderer_address'];?>).
    <br/>Ceci peut prendre jusqu'à <?php echo $ssh_timeout;?> secondes. 
            Veuillez ne pas rafraichir la page.
    <br/><br/><br/>
    <img src="img/loading_white.gif"/>
</div>

<script>select_option();</script>