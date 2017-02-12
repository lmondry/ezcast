
<table class="table table-striped">
    <thead>
        <tr>
            <?php echo $colOrder->insertThSort("albumName", "Nom de l'album", "left"); ?> 
            <th>Nombre de discussions</th>
            <th>Nombre de discussions (%)</th>
            <th>Nombre de commentaires</th>
            <th>Nombre de commentaires par discussion</th>
            <!--<th>Nombre de commentaires par jour</th>-->
        </tr>
    </thead>
    <tfoot>
        <tr class="info">
            <td></td>
            <td>Total : <?php echo $threadsCount; ?></td>
            <td></td>
            <td>Total : <?php echo $commentsCount; ?></td>
            <td>Moyenne : <?php echo number_format((float)($commentsCount/$threadsCount), 2, '.','');?></td>
            <!--<td></td>-->
        </tr>
    </tfoot>
    <tbody>
        <?php 
        foreach ($allAlbums as $albumArr) {
            $nbThreads = stat_threads_count_by_album($albumArr["albumName"]);
            $nbComments = stat_comments_count_by_album($albumArr["albumName"]);
        ?>
        <tr>
            <td class="left"><?php echo $albumArr["albumName"]; ?></td>
            <td><?php echo $nbThreads; ?></td>
            <td><?php echo number_format((float)(($nbThreads/$threadsCount)*100), 2, '.',''); ?></td>
            <td><?php echo $nbComments; ?></td>
            <td><?php echo number_format((float)($nbComments/$nbThreads), 2, '.',''); ?></td>
            <!--<td>n/a</td>-->
        </tr>
        <?php 
        }
        ?>
    </tbody>
    
</table>

