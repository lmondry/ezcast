
<table class="table table-striped">
    <thead>
        <tr>
            <th class="left">Album name</th>
            <th>Number of discussions</th>
            <th>Number of comments</th>
            <th>Number of comments by discussion</th>
            <!--<th>Nombre de commentaires par jour</th>-->
        </tr>
    </thead>
    <tfoot>
        <tr class="warning">
            <td></td>
            <td>Total : <?php echo $threadsCountMonth; ?></td>
            <td>Total : <?php echo $commentsCountMonth; ?></td>
            <td>Average : <?php echo number_format((float)($commentsCountMonth/$threadsCountMonth), 2, '.',''); ?></td>
            <!--<td></td>-->
        </tr>
    </tfoot>
    <tbody>
        <?php 
        foreach ($allAlbumsMonth as $albumMonth) {
            $nbThreads = stat_threads_count_by_album_and_month($albumMonth["albumName"], $_SESSION['currentMonth']);
            $nbComments = stat_comments_count_by_album_and_month($albumMonth["albumName"], $_SESSION['currentMonth']);
        ?>
        <tr>
            <td class="left"><?php echo $albumMonth["albumName"]; ?></td>
            <td><?php echo $nbThreads; ?></td>
            <td><?php echo $nbComments; ?></td>
            <td><?php echo number_format((float)($nbComments/$nbThreads), 2, '.',''); ?></td>
            <!--<td>n/a</td>-->
        </tr>
        <?php 
        }
        ?>
    </tbody>
    
</table>

