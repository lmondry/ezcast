<div class="page_title">Suivi des enregistrements</div>

<form method="GET" class="search_asset pagination" style="width: 100%;">
    
    <input type="hidden" name="action" value="<?php echo $input['action']; ?>" >
    <input type="hidden" name="post" value="">
    
    
    <!-- Date and status -->
    <div class="form-group">
        <div class="row">
            <div class="col-md-4 col-sm-6">
                <label for="startDate">De</label>
                <div class='input-group date' id='startDate'>
                    <input type='text' name='startDate' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar">
                        </span>
                    </span>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <label for="endDate">A</label>
                <div class='input-group date' id='endDate'>
                    <input type='text' name='endDate' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar">
                        </span>
                    </span>
                </div>
            </div>
            <div class="col-md-3">
                <label for="status">Statut</label>
                <select name="status[]" class="form-control selectpicker" multiple data-actions-box="true" 
                        title="Selectionner le statut">
                    <?php
                    foreach (EventStatus::getAllEventStatus() as $status) {
                        echo '<option value="'.$status.'"';
                        if(isset($input) && array_key_exists('status', $input) && 
                                is_array($input['status']) && in_array($status, $input['status'])) {
                            echo ' selected';
                        }
                        echo ' data-content="<span class=\'label label-'.EventStatus::getColorStatus($status).'\'>'.$status.'</span>"';
                        echo '>'.$status.
                            '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-1">
                <label for=""></label><br />
                <button type="button" class="btn btn-primary" 
                        data-toggle="modal" data-target="#help_modal">
                    <span class="glyphicon glyphicon-info-sign icon-white"></span> 
                </button>
            </div>
        </div>
    </div>
    
    <script type="text/javascript">
        $(function () {
            
            $('#startDate').datetimepicker({
                showTodayButton: true, 
                showClose: true,
                sideBySide: true,
                format: 'YYYY-MM-DD HH:mm',
                <?php
                if(isset($input) && array_key_exists('startDate', $input) && $input['startDate'] != 0) {
                    echo "defaultDate: new Date('".$input['startDate']."')";
                } else {
                    echo 'defaultDate: moment().subtract(4, \'month\')';
                }
                ?>
            });
            
            $('#endDate').datetimepicker({
                showTodayButton: true,
                showClose: true,
                sideBySide: true,
                format: 'YYYY-MM-DD HH:mm',
                <?php
                if(isset($input) && array_key_exists('endDate', $input) && $input['endDate'] != 0) {
                    echo "defaultDate: new Date('".$input['endDate']."')";
                } else {
                    echo 'defaultDate: moment().add(1, \'days\')';
                }
                ?>
            });
            
            $("#startDate").on("dp.change", function (e) {
                $('#endDate').data("DateTimePicker").minDate(e.date);
            });
            $("#endDate").on("dp.change", function (e) {
                $('#startDate').data("DateTimePicker").maxDate(e.date);
            });
            
        });
        
    </script>
        
    <div class="form-group">
        <div class="row">
            <div class="col-md-5">
                <label class="sr-only" for="asset">Asset</label>
                <input type="text" class="form-control" name="asset" id="asset" placeholder="Asset"
                    value="<?php if(isset($input) && array_key_exists('asset', $input)) { echo $input['asset']; } ?>">
            </div>
            <div class="col-md-3">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="view_all" 
                            <?php if(isset($input) && array_key_exists('view_all', $input)) { echo 'checked'; } ?>> 
                        Voir tous les résultats
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-block btn-success">
                    <span class="glyphicon glyphicon-search icon-white"></span> 
                    Rechercher
                </button>
            </div>
        </div>
    </div>
    
</form>

<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="help_modal" tabindex="-1" role="dialog" aria-labelledby="Help_Modal_Label">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="Help_Modal_Label">Informations</h4>
                </div>
                <div class="modal-body">
                    <br />
                    <h3>Automatique</h3>
                    <h4>AUTO_SUCCESS</h4>
                    <p>
            Statut mis automatiquement lorsque tout va bien
        </p>
                    <h4>AUTO_SUCCESS_ERRORS</h4>
                    <p>
            Statut mis automatiquement lorsque l'on a le résultat mais qu'il y a des erreurs critiques
        </p>
                    <h4>AUTO_SUCCESS_WARNINGS</h4>
                    <p>
            Statut mis automatiquement lorsque l'on a le résultat mais qu'il y a des warnings/erreurs
        </p>
                    <h4>AUTO_FAILURE</h4>
                    <p>
            Statut mis automatiquement lorsqu'il y a un problème
        </p>
                    <br />
                    <h3>Manuel</h3>
                    <h4>MANUAL_OK</h4>
                    <p>
            Statut mis (manuellement) lorsque tout va bien
        </p>
                    <h4>MANUAL_PARTIAL_OK</h4>
                    <p>
            Statut mis (manuellement) lorsque le problème a été réglé mais avec perte partielle
        </p>
                    <h4>MANUAL_FAILURE</h4>
                    <p>
            Statut mis (manuellement) lorsque le problème a été vu mais qu'il y a eu une perte total
        </p>
                    <h4>MANUAL_IGNORE</h4>
                    <p>
            Statut mis (manuellement) lorsque l'asset n'est pas important (permet également de lier à un autre asset)
        </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                </div>
        </div>
    </div>
</div>
