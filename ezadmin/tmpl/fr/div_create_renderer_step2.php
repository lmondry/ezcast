
<script>
function swap(div_a, div_b) {
    document.getElementById(div_a).style.display = 'block';
    document.getElementById(div_b).style.display = 'none';
}
swap('main_step_2', 'load_step_2')
</script>

<div class="page_title">Créer renderer > Configuration SSH</div>

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
        Ajoutez la <b>clé publique</b> affichée ci-dessous sur le serveur 
            distant (renderer) dans <b>~<?php echo $_SESSION['renderer_user'];?>/.ssh/authorized_keys</b> 
            et cliquez sur "Continuer" pour tester la connexion SSH. 
        <br/>(<?php echo $_SESSION['renderer_address'];?>)
        <br/><br/>
        <textarea readonly readonly="true" class="form-control no_resize" style="width: 780px; height: 180px;" rows="14" cols="170">
            <?php echo $ssh_public_key; ?>
        </textarea>
        <br />

        <div class="form-group text-center">
            <input type="submit" class="btn btn-primary" name="submit_step_2_prev" value="Précédent"/>
            <input type="submit" class="btn btn-primary" name="submit_step_2_next" onclick="swap('load_step_2','main_step_2');" value="Suivant"/>
        </div>
    </form>
</div>

<div id="load_step_2" style="text-align:center; display: none">
    <br/><br/>
    Vérification de la connexion SSH avec le serveur distant (renderer) (<?php echo $_SESSION['renderer_address'];?>).
    <br/>Ceci peut prendre jusqu'à <?php echo $ssh_timeout;?> secondes. 
            Veuillez ne pas rafraichir la page.
    <br/><br/><br/>
    <img src="img/loading_white.gif"/>
</div>