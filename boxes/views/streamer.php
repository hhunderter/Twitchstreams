<?php $streamer = $this->get('streamer'); ?>

<?php if (!empty($streamer)): ?>
  <ul class="list-unstyled">
    <?php foreach($streamer as $stream) : ?>
      <li>
        <a href="<?=$this->getUrl(array('module' => 'twitchstreams', 'controller' => 'index', 'action' => 'index', 'id' => $stream->getId())) ?>"><?=$stream->getUser() ?></a> <?=$this->getTrans('playing') ?> <?=$stream->getGame() ?>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>
