
<div class="page_title">Room list</div>

<!-- Search form -->
<form method="GET" class="search_classroom">
    
    <input type="hidden" name="action" value="<?php echo $input['action']; ?>" >
    <input type="hidden" name="post"/>
    
    <!-- Classroom id and name -->
    <div class="form-group">
        <div class="row">
            <div class="col-md-4">
                
                <label class="sr-only" for="room_ID">Room number</label>
                <input class="form-control" type="text" placeholder="Room number" 
                    title="Room number" name="room_ID" 
                    value="<?php if(isset($input) && isset($input['room_ID'])) { echo  $input['room_ID']; } ?>" />
            </div>
            <div class="col-md-4">
                <label class="sr-only" for="name">Room name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Room name"
                    value="<?php if(isset($input) && array_key_exists('name', $input)) { echo $input['name']; } ?>">
            </div>
            <div class="col-md-4">
                <label class="sr-only" for="IP">IP address (master)</label>
                <input type="text" class="form-control" name="IP" id="IP" placeholder="IP address (master)"
                    value="<?php if(isset($input) && array_key_exists('IP', $input)) { echo $input['IP']; } ?>">
            </div>
        </div>
    </div>
    
    
    
    <!-- Context, message and submit -->
    <div class="form-group">
        <div class="row">
            <div class="col-md-3">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="being_record" value="1"
                            <?php if(isset($input) && array_key_exists('being_record', $input)) {
                                   echo 'checked';
                               } ?>>  
                        Being Recorded
                    </label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="only_classroom_active" value="1" 
                               <?php if(isset($input) && array_key_exists('only_classroom_active', $input)) {
                                   echo 'checked';
                               } ?>> 
                        Only activated classroom
                    </label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="only_online" value="1"
                               <?php if(isset($input) && array_key_exists('only_online', $input)) {
                                   echo 'checked';
                               } ?>> 
                        Only online
                    </label>
                </div>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-block btn-success">
                    <span class="glyphicon glyphicon-search icon-white"></span> 
                    Search
                </button>
            </div>
        </div>
    </div>
    
</form>
