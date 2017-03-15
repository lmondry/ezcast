
<?php
if (isset($_SESSION['monthStats'])) {
    ?>
    <script>
        var ind2 = 0;
        var dataArrayPieChartMonth = new Array();
    </script>
    <?php
    $threadsCountMonth = $_SESSION['monthStats']['threadsCount'];
    $commentsCountMonth = $_SESSION['monthStats']['commentsCount'];
    $allAlbums = stat_album_get_all();
    $allAlbumsMonth = array();
    foreach ($allAlbums as $albumArr) {
        $nbThreadsTmp = stat_threads_count_by_album_and_month($albumArr["albumName"], $_SESSION['currentMonth']);
        if ($nbThreadsTmp != "0") {
            $allAlbumsMonth[] = $albumArr;
            ?>
            <script>
                dataArrayPieChartMonth[ind2] = [<?php echo json_encode($albumArr["albumName"]); ?>, <?php echo $nbThreadsTmp; ?>];
                ind2 += 1;
            </script>
            <?php
        }
    }
    ?>
    <script>
        var pieChartMonth = jQuery.jqplot('pieChartMonth', [dataArrayPieChartMonth],
                {
                    title: 'Number of discussions by album',
                    seriesDefaults: {
                        // Make this a pie chart.
                        renderer: jQuery.jqplot.PieRenderer,
                        rendererOptions: {
                            showDataLabels: true
                        }
                    },
                    legend: {
                        show: true,
                        location: 'e'
                    },
                    highlighter: {
                        show: true,
                        useAxesFormatters: false,
                        tooltipFormatString: '%s',
                        sizeAdjust: 1.5
                    }
                }
        );
    </script>
    
    <center>
        <div id="pieChartMonth" class="pie">
            <!-- Chart container -->
        </div>
    </center>
    <h4>Totals</h4>
    <p class="default">Number of discussions   <span class="label label-default"><?php echo $threadsCountMonth; ?></span></p>
    <p class="default">Number of comments   <span class="label label-default"><?php echo $commentsCountMonth; ?></span></p>
    <br />
    <div id='tableMonth' class="table-responsive">
        <?php include_once template_getpath('div_stats_threads_table_month.php'); ?>
    </div>
<?php
} else {
    echo '<label class="label label-info">NO DATA</label>';
}
?>
