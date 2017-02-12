
<?php
require_once 'config.inc';
?>

<div class="page_title">Renderers list</div>


<table class="table table-striped table-hover table-condensed renderers">
    <tr>
        <th></th>
        <th>Index</th>
        <th>Name</th>
        <th>Hostname</th>
        <th>Encoder program</th>
        <th>Jobs</th>
        <th>Load</th>
        <th>Threads/job</th>
        <th>Enabled</th>
        <th>Enable/Disable</th>
        <th></th>
    </tr>

    <?php
    require_once '../commons/lib_scheduling.php';
    foreach ($renderers as $r) {
        //todo, move this in javascript, ping shouldn't lock page loading
        exec('ping -c 1 '.$r['host'], $output, $return_val); 
        if($return_val != 0){
            $r['no_ping'] = true;
        } else {
            $r['no_ping'] = false;
            $r = lib_scheduling_renderer_metadata($r);
        }
        //var_dump($r2);
        ?>
        <tr class="<?php echo $class; ?>">
            <td><?php if($r['no_ping'] === true) echo '<span title="No answer to ping requests"><span class="glyphicon glyphicon-warning-sign"></span></span>';
                      if(isset($r['ssh_error']) && $r['ssh_error'] === true) echo '<span title="No answer to ssh requests"><span class="glyphicon glyphicon-warning-sign"></span></span>';?></td>
            <td><?php echo $r['performance_idx']; ?></td>
            <td class="renderer_name"><?php echo $r['name']; ?></td>
            <td><?php echo $r['host']; ?></td>
            <td><span title="<?php echo $r['encoding_desc'] ?>"><?php echo $r['encoding_pgm']; ?></span></td>
            <td><?php echo $r['num_jobs'] . '/' . $r['max_num_jobs']; ?></td>
            <td><?php echo $r['load']; ?></td>
            <td><?php echo $r['max_num_threads']; ?></td>
            <td><?php echo $r['status'] == 'enabled' ? '<span class="glyphicon glyphicon-ok"></span>' : '<span></span>'; ?></td>
            <td>
                <button class="btn btn-sm enabled_button <?php echo $r['status'] != 'enabled' ? 'btn-success' : '' ?>">
                    <?php echo $r['status'] != 'enabled' ? 'Enable' : 'Disable' ?>
                </button>
            </td>
            <td>
                <button class="btn btn-sm btn-danger delete_button">
                    <span class="glyphicon glyphicon-trash"></span>
                </button>
            </td>
        </tr>
        <?php
    }
    ?>
</table>

<script>

    $(function() {

        $("table.renderers .enabled_button").click(function() {
            $this = $(this);

            var renderer = $this.parent().parent().find("td.renderer_name").text();

            if ($this.hasClass('btn-success')) {
                $.ajax("index.php?action=enable_renderer", {
                    type: "post",
                    data: {
                        name: renderer
                    },
                    success: function(jqXHR, textStatus) {

                        var data = JSON.parse(jqXHR);

                        if (data.error) {
                            if (data.error == '1')
                                alert("Impossible to change the state of this room.");
                            return;
                        }

                        $this.removeClass('btn-success');
                        $this.text('Disable');
                        $this.parent().prev().find(".glyphicon").addClass('icon-ok');
                    }
                });
            } else {
                $.ajax("index.php?action=disable_renderer", {
                    type: "post",
                    data: {
                        name: renderer
                    },
                    success: function(jqXHR, textStatus) {

                        var data = JSON.parse(jqXHR);

                        if (data.error) {
                            if (data.error == '1')
                                alert("Impossible to change the state of this renderer.");
                            return;
                        }

                        $this.addClass('btn-success');
                        $this.text('Enable');
                        $this.parent().prev().find(".glyphicon").removeClass('icon-ok');
                    }
                });
            }
        });



        $("table.renderers .delete_button").click(function() {
            if (!confirm('Are you sure you want to delete this item ?'))
                return;
            var $this = $(this);

            var renderer = $this.parent().parent().find("td.renderer_name").text();

            $.ajax("index.php?action=remove_renderer", {
                type: "post",
                data: {
                    name: renderer
                },
                success: function(jqXHR, textStatus) {
                    var data = JSON.parse(jqXHR);

                    if (data.error) {
                        if (data.error == '1')
                            alert("An error has occured during the renderer deletion.");
                        return;
                    } else {
                            alert("You can now delete EZrenderer files on the remote server (renderer).");
                    }

                    $this.parent().parent().hide(400, function() {
                        $(this).remove();
                    });
                }
            });
        });

    });

</script>