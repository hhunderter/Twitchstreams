<div class="table-responsive">
  <table class="table table-hover table-striped">
    <colgroup>
      <col class="icon_width">
      <col class="icon_width">
      <col />
      <col class="col-lg-1">
      <col class="col-lg-3">
      <col class="col-lg-1">
    </colgroup>
    <tr>
      <th></th>
      <th></th>
      <th><?=$this->getTrans('streamer') ?></th>
      <th><?=$this->getTrans('online') ?></th>
      <th><?=$this->getTrans('game') ?></th>
      <th><?=$this->getTrans('viewers') ?></th>
    </tr>
    <?php if ($this->get('streamer') != ''): ?>
      <?php foreach ($this->get('streamer') as $streamer): ?>
        <tr>
          <td><?=$this->getEditIcon(array('action' => 'treat', 'id' => $streamer->getId())); ?></td>
          <td><?=$this->getDeleteIcon(array('action' => 'delete', 'id' => $streamer->getId())) ?></td>
          <td><?=$streamer->getUser() ?></td>
          <td>
              <?php if ($streamer->getOnline() == 1): ?>
                  <?=$this->getTrans('yes') ?>
              <?php else: ?>
                  <?=$this->getTrans('no') ?>
              <?php endif; ?>
          </td>
          <td><?=$streamer->getGame() ?></td>
          <td><?=number_format($streamer->getViewers(), 0, '','.') ?></td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td colspan="6"><?=$this->getTrans('noStreamer') ?></td>
      </tr>
    <?php endif; ?>
  </table>
</div>
