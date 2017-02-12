
<table class="table table-striped">
    <thead>
        <tr>
            <th class="left">Nom de l'album</th>
            <th>Nombre de discussions</th>
            <th>Nombre de commentaires</th>
            <th>Nombre de commentaires par discussion</th>
        </tr>
    </thead>
    <tfoot>
        <tr class="warning">
            <td></td>
            <td>Total : <?php echo $threadsCountNDays; ?></td>
            <td>Total : <?php echo $commentsCountNDays; ?></td>
            <td>Moyenne : <?php echo $commentsCountNDays/$threadsCountNDays; ?></td>
            <!--<td></td>-->
        </tr>
    </tfoot>
    <tbody>
        <?php 
        foreach ($allAlbumsNDays as $albumNDay) {
            $nbThreads = stat_threads_count_by_album_and_date_interval($albumNDay["albumName"], $_SESSION['nDaysStats']['nDaysEarlier'], $_SESSION['nDaysStats']['nDaysLater']);
            $nbComments = stat_comments_count_by_album_and_date_interval($albumNDay["albumName"], $_SESSION['nDaysStats']['nDaysEarlier'], $_SESSION['nDaysStats']['nDaysLater']);
        ?>
        <tr>
            <td class="left"><?php echo $albumNDay["albumName"]; ?></td>
            <td><?php echo $nbThreads; ?></td>
            <td><?php echo $nbComments; ?></td>
            <td><?php echo $nbComments/$nbThreads; ?></td>
            <!--<td>n/a</td>-->
        </tr>
        <?php 
        }
        ?>
    </tbody>
    
</table>

