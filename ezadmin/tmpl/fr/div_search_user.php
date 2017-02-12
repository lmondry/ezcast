
<div class="page_title">Liste des utilisateurs</div>

<!-- Search form -->
<form method="POST" action="index.php" class="form-inline search_user">
    <input type="hidden" name="action" value="view_users" />
    
    <input type="hidden" name="post"/>
    <input type="hidden" name="page" value="1" />
    <input type="hidden" name="col" value="<?php if(isset($input) && isset($input['col'])) echo $input['col'] ?>" />
    <input type="hidden" name="order" value="<?php if(isset($input) && isset($input['order'])) echo $input['order'] ?>" />
    
    <input class="form-control input-large auto-clear placeholder" type="text" placeholder="Identifiant" title="Identifiant" name="user_ID" value="<?php if(isset($input) && isset($input['user_ID'])) echo $input['user_ID']; ?>" />
    <input class="form-control input-large auto-clear placeholder" type="text" placeholder="Prénom" title="Prénom" name="forename" value="<?php if(isset($input) && isset($input['forename'])) echo $input['forename']; ?>" />
    <input class="form-control input-large auto-clear placeholder" type="text" placeholder="Nom de famille" title="Nom de famille" name="surname" value="<?php if(isset($input) && isset($input['surname'])) echo $input['surname']; ?>" />
    
    <input type="submit" name="search" value="Rechercher" class="btn btn-primary">
    <input type="reset" name="reset" value="Effacer" class="btn"> <br />
    <div><a href="#" onclick="javascript:toggleVisibility('options_block');"><span class="glyphicon glyphicon-plus"></span> Options</a></div>
    <div class="row" style="display: none;" id="options_block">
        
        <div class="col-md-2 col-md-offset-1">
            <label class="control-label" style="display: inline-block;">
                Origine: 
            </label>
            <div class="controls">
                <label class="checkbox">
                    <input type="checkbox" title="Interne" name="intern" <?php echo isset($input['intern']) ? 'checked' : ''; ?> />
                    Interne
                </label>
            </div>
            <div class="controls">
                <label class="checkbox">
                    <input type="checkbox" title="Externe" name="extern" <?php echo isset($input['extern']) ? 'checked' : ''; ?> />
                    Externe
                </label>  
            </div>
        </div>
        
        <div class="col-md-2">
            <label class="control-label" style="display: inline-block;">
                Administrateur: 
            </label>
            <div class="controls">
                <label class="checkbox">
                    <input type="checkbox" title="Oui" name="is_admin" <?php echo isset($input['is_admin']) ? 'checked' : ''; ?> />
                    Oui
                </label>
            </div>
            <div class="controls">
                <label class="checkbox">
                    <input type="checkbox" title="Non" name="is_not_admin" <?php echo isset($input['is_not_admin']) ? 'checked' : ''; ?> />
                    Non
                </label>
            </div>
        </div>
    </div>
</form>

<hr>
