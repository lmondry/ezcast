<?php 
if(isset($errorActionMsg)) { ?>
    <div class="alert alert-danger col-md-10 col-md-offset-1" role="alert">
    Une erreur c'est produite avec les paramètres (<?php echo $errorActionMsg; ?>)
    </div>
<?php }

if(isset($cronWarningMsg) && $cronWarningMsg) { ?>
    <div class="alert alert-warning col-md-10 col-md-offset-1" role="alert">
    Attention, aucun statut n'a été posté depuis un certains temps. Vérifiez que la tache "cron" est 
            toujours activée.<br />
            Si elle était désactivée, exécutez le script: 
            <code>php <?php echo $ezmanager_basedir; ?>cli_fill_assets_status.php all</code>
        
    </div>
<?php }

if(isset($pagination)) {
    $pagination->insert();
} 
?>


<div class="table-responsive col-md-12">
    <table class="table table-striped table-hover table-bordered events sort_col">
        <tr>
            <th></th>
            <?php echo $colOrder->insertThSort("asset", "Asset"); ?>
            <?php echo $colOrder->insertThSort("status_time", "Date du statut"); ?>
            <?php echo $colOrder->insertThSort("author", "Auteur"); ?>
            <?php echo $colOrder->insertThSort("status", "Statut"); ?>
            <th>Message</th>
        </tr>

        <?php 
        foreach($resStatus as &$status) { ?>
            <tr class="<?php echo EventStatus::getColorStatus($status['status']); ?>">
                <td style="text-align: center;">
                    <button type="button" class="btn btn-default btn-sm" id="check" 
                            data-toggle="modal" data-target="#modal_check" data-asset="<?php echo $status['asset']; ?>">
                        <span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span>
                    </button>
                    <button type="button" class="btn btn-default btn-sm" id="link"
                    <?php if(array_key_exists($status['asset'], $listChildren) || in_array($status['asset'], $listAssetWithParent)) {
                            echo 'disabled="disabled"';
                    } else { ?>
                            data-toggle="modal" data-target="#modal_link" data-asset="<?php echo $status['asset']; ?>"
                    <?php } ?>
                    >
                        <span class="glyphicon glyphicon-link" aria-hidden="true"></span>
                    </button>
                </td>
                <td style="text-align: left;">
                    <a href="./index.php?action=view_track_asset&post=&startDate=1970-01-01+00%3A00&view_all=on&asset=<?php echo $status['asset']; ?>">
                        <?php echo $status['asset']; ?>
                    </a>
                    <a style="float: right;" href="./index.php?action=view_events&post=&startDate=1970-01-01+00%3A00&asset=<?php echo $status['asset']; ?>">
                        <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>
                    </a>
                    <?php if(array_key_exists($status['asset'], $listChildren)) {
                        foreach($listChildren[$status['asset']] as $children) {
                            echo '<br />';
                            echo '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> ';
                            echo '<a href="./index.php?action=view_track_asset&post=&startDate=1970-01-01+00%3A00&view_all=on&asset='.
                                    $children.'">';
                            echo $children . '  ';
                            echo '</a>';
                            
                            // Remove parent
                            echo '<form name="form" method="POST" style="display: inline;">';
                            echo '<input type="hidden" name="current_asset" value="'.$children.'" />';
                            echo '<input type="hidden" name="modal_action" value="remove_parent">';
                            echo '<a href="#" onclick="this.parentElement.submit();">';
                            echo '<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>';
                            echo '</a>';
                            echo '</form>';
                        }
                    } ?>
                </td>
                <td><?php echo $status['status_time']; ?></td>
                <td><?php echo $status['author']; ?></td>
                <td><span class="label label-<?php echo EventStatus::getColorStatus($status['status']); ?>">
                        <?php echo $status['status']; ?>
                    </span>
                </td>
                <td
                <?php if(array_key_exists('min_description', $status)) { ?>
                    data-container="body" data-toggle="popover" data-trigger="hover" 
                        data-placement="right" data-content="<?php echo $status['description']; ?>"><?php 
                    echo $status['min_description'];
                } else { 
                    echo '>'.$status['description'];
                } ?>    
                </td>
            </tr>
        <?php } ?>
    </table>
    
    <!-- Link an asset to an other -->
    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalLink" id="modal_link">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Définir le parent</h4>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="modal_action" value="new_parent">
                        <input id="asset_name" type="hidden" name="current_asset" value="">

                        <div class="form-group">
                            <label for="parent_asset" class="control-label">Asset étant le parent:</label>
                            <input type="text" class="form-control" id="parent_asset" placeholder="Asset" name="parent_asset">
                            <span id="helpBlock" class="help-block">
                                <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> 
                                Le statut de l'asset actuel sera automatiquement mis en Ignorer
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-success">Sauvegarder</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    
    <!-- Check an asset -->
    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalCheck" id="modal_check">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Changer le statut</h4>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="modal_action" value="new_status">
                        <input id="asset_name" type="hidden" name="current_asset" value="">
                        
                        <div class="form-group">
                            <label for="new_status">Statut</label>
                            <select name="new_status" class="form-control">
                                <?php
                                foreach (EventStatus::getManualEventStatus() as $status) {
                                    echo '<option value="'.$status.'"';
                                    if(isset($input) && array_key_exists('status', $input) && 
                                            $input['status'] != "" && $input['status'] == $status) {
                                        echo ' selected';
                                    }
                                    echo '>'.$status.
                                        '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="description">Message</label>
                            <textarea class="form-control" name="new_description" rows="4" placeholder="Message"></textarea>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-success">Sauvegarder</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
        
</div>

<?php if(isset($pagination)) {
    $pagination->insert();
} ?>



<script> 
$(document).ready(function(){
    $('[data-toggle="popover"]').popover(); 
    
    $("button[data-toggle='modal']#link").on('click', function(e) {
        var button = $(this); //clicked object
        var assetName = button.attr('data-asset'); //modal element id 
        var modal = $('#modal_link');
        modal.find('.modal-body input#asset_name').val(assetName);
    });
    
    $("button[data-toggle='modal']#check").on('click', function(e) {
        var button = $(this); //clicked object
        var assetName = button.attr('data-asset'); //modal element id 
        var modal = $('#modal_check');
        modal.find('.modal-body input#asset_name').val(assetName);
    });
    

}); 

</script>