<?php $streamer = $this->get('streamer'); ?>

<?php for ($i = 0; $i < sizeof($streamer); $i++): ?>
  <?php if (isset($streamer[$i])): ?>
    <div class="panel panel-default">
      <div class="panel-heading"><?=$streamer[$i]->getTitle() ?></div>
      <div class="panel-body">
        <div class="col-md-4">
          <a href="<?=$streamer[$i]->getLink() ?>" target="_blank">
            <img src="<?=$streamer[$i]->getPreviewMedium() ?>" title="<?=$streamer[$i]->getUser().' '.$this->getTrans('playing').' '.$streamer[$i]->getGame() ?>">
          </a>
        </div>
        <div class="col-md-8">
          <ul class="list-group">
            <li class="list-group-item">
              <?=$this->getTrans('streamer') ?>
              <span class="badge"><?=$streamer[$i]->getUser() ?></span>
            </li>
            <li class="list-group-item">
              <?=$this->getTrans('game') ?>
              <span class="badge"><?=$streamer[$i]->getGame() ?></span>
            </li>
            <li class="list-group-item">
              <?=$this->getTrans('viewers') ?>
              <span class="badge"><?=number_format($streamer[$i]->getViewers(), 0, '','.') ?></span>
            </li>
            <li class="list-group-item">
              <?=$this->getTrans('onlineSince') ?>
              <span class="badge"><?=$streamer[$i]->getCreatedAt() ?></span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  <?php endif; ?>
<?php endfor; ?>
