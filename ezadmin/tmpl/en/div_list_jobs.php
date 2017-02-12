<?php
require_once 'config.inc';
?>

<div class="page_title">Jobs list</div>

<?php if(empty($jobs)) { ?>
    <div class="alert alert-warning" role="alert">No job currently</div>
<?php } ?>
<table class="table table-striped table-hover table-condensed classrooms">
    <tr>
        <th>Priority</th>
        <th>Submit date</th>
        <th>Author</th>
        <?php global $classrooms_category_enabled;
        if($classrooms_category_enabled) { ?>
            <th>Origin</th>
        <?php } ?>
        <th>Renderer</th>
        <th>Status</th>
        <th>Duration</th>
        <th>Actions</th>
    </tr>
    
    <?php 
    require_once '../commons/lib_scheduling.php';
    
    foreach($jobs as $job) {
        if(empty($job['done'])) {
            $date = '';
            $threshold1 = 0; // If duration above threshold: display in yellow as a warning
            $threshold2 = 0; // Same as above, except if we go above this threshold it is time to seriously worry
            if(!empty($job['sent'])) {
                $date = $job['sent'];
                $threshold1 = 18000; // 18000s = 5 hours
                $threshold2 = 43200; // 43200s = 12 hours
            }
            else if(!empty($job['created'])) {
                $date = $job['created'];
                $threshold1 =  3600; //  3600s = 1 hour
                $threshold2 = 18000; // 18000s = 5 hours
            }
            
            if(!empty($date)) {
                $dt = new DateTime();

                $dt = $dt->createFromFormat('Y-m-d H:i:s', $date);
                $datetime = $dt->getTimestamp();
                $duration = abs(time() - $datetime);
                
                $class = 'success';
                if($duration > $threshold2)
                    $class = 'danger';
                else if ($duration > $threshold1)
                    $class = 'info';
            }
            else {
                $class = '';
            }
            ?>
            <tr class="<?php echo $class; ?>">
                <td><?php echo $job['priority']; ?></td>
                <td><?php echo $job['created']; ?></td>
                <td><?php echo $job['sender']; ?></td>
                <?php global $classrooms_category_enabled;
                if($classrooms_category_enabled) { ?>
                    <td><?php echo $job['origin']; ?></td>
                <?php } ?>
                <td><?php echo $job['renderer']; ?></td>
                <td>
                    <?php if(in_array($job, scheduler_frozen_get())) {
                        echo '<span class="glyphicon glyphicon-minus-sign" title="Frozen"></span> Frozen';
                    }
                    else if(!empty($job['done'])) {
                        echo '<span class="glyphicon glyphicon-ok-sign" title="Finished on '.$job['done'].'"></span> Finished';
                    } else if(!empty($job['sent'])) {
                        echo '<span class="glyphicon glyphicon-refresh" title="Sent on '.$job['created'].'"></span> Processing';
                    } else if(!empty($job['created'])) {
                        echo '<span class="glyphicon glyphicon-time" title="Created on '.$job['created'].'"></span> Waiting';
                    } ?>
                </td>
                <td>
                    <?php
                    $hours = floor($duration / 3600);
                    $minutes = floor(($duration % 3600) / 60);
                    $seconds = ($duration % 3600) % 60;

                    if($hours > 0)
                        echo $hours .'h ';
                    if($minutes > 0)
                        echo $minutes.'m ';
                    if($seconds > 0)
                        echo $seconds.'s';
                    ?>
                </td>
                <td>
                    <?php if(empty($job['done']) && empty($job['sent'])) { ?>
                        <?php if(!in_array($job, scheduler_frozen_get())) { ?>
                            <a href="index.php?action=job_priority_up&amp;job=<?php echo $job['uid']; ?>"><span class="glyphicon glyphicon-chevron-up" title="Increase priority"></span></a>&nbsp;
                            <a href="index.php?action=job_priority_down&amp;job=<?php echo $job['uid']; ?>"><span class="glyphicon glyphicon-chevron-down" title="Decrease priority"></span></a>&nbsp;
                        <?php } ?>
                        <?php if(in_array($job, scheduler_frozen_get())) { ?>
                            <a href="index.php?action=free_unfreeze_job&amp;job=<?php echo $job['uid']; ?>"><span class="glyphicon glyphicon-repeat" title="Unfreeze job"></span></a>
                        <?php } else { ?>
                            <a href="index.php?action=free_unfreeze_job&amp;job=<?php echo $job['uid']; ?>"><span class="glyphicon glyphicon-ban-circle" title="Freeze job"></span></a>
                        <?php } ?>
                    <?php } else if(empty($job['done']) && !empty($job['sent'])) {
                        ?>
                        <a href="index.php?action=job_kill&amp;job=<?php echo $job['uid']; ?>"><span class="glyphicon glyphicon-remove" title="Kill job"></span></a>
                        <?php
                    } ?>
                </td>
            </tr>
            <?php
        }
    }
    ?>
</table>

