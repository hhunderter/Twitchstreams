<?php $streamer = $this->get('streamer'); ?>

<?php if (!empty($streamer)): ?>
  <ul class="list-unstyled">
    <?php foreach ($streamer as $stream): ?>
      <li>
        <a href="<?=$this->getUrl(['module' => 'twitchstreams', 'controller' => 'index', 'action' => 'show', 'id' => $stream->getId()]) ?>"><?=$stream->getUser() ?></a> <?=$this->getTrans('playing') ?> <?=$stream->getGame() ?>
      </li>
    <?php endforeach; ?>
  </ul>
<?php else: ?>
  <?=$this->getTrans('noStreamer') ?>
<?php endif; ?>
