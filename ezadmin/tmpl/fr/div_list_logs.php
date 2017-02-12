<table class="table table-striped table-hover table-condensed courses">
    <tr>
        <th>Date/heure</th>
        <th>Catégorie</th>
        <th>Message</th>
        <th>Auteur</th>
    </tr>

    <?php foreach ($logs as $l) {
        ?>
        <tr>
            <td><?php echo date('H:i:s d/m/Y', strtotime($l['time'])); ?></td>
            <td><?php echo $l['table']; ?></td>
            <td><?php echo $l['message']; ?></td>
            <td><?php echo $l['author']; ?></td>
        </tr>
        <?php
    }
    ?>

</table>