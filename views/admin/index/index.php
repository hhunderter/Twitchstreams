<table id="streamerTable" class="table">
    <colgroup>
        <col class="icon_width" />
        <col class="icon_width" />
        <col />
        <col />
    </colgroup>
    <tr>
        <th></th>
        <th></th>
        <th>User</th>
        <th>Online</th>
        <th>Game</th>
        <th>Viewers</th>
    </tr>
    <?php 
    foreach($this->get('streamer') as $streamer) : ?>
        <tr>
            <td><?=$this->getEditIcon(array('action' => 'treat', 'id' => $streamer->getId())); ?></td>
            <td><?=$this->getDeleteIcon(array('action' => 'delete', 'id' => $streamer->getId())) ?></td>
            <td><?php echo $streamer->getUser(); ?></td>
            <td><?php echo $streamer->getOnline(); ?></td>
            <td><?php echo $streamer->getGame(); ?></td>
            <td><?php echo $streamer->getViewers(); ?></td>
        </tr>
    <?php endforeach; ?>
</table>