<?php $streamers = $this->get('streamer'); ?>

<link href="<?=$this->getModuleUrl('static/css/streams.css') ?>" rel="stylesheet">

<div id="streamer">
<?php if ($streamers): ?>
    <?php foreach ($streamers as $streamer): ?>
    <?php $date = new \Ilch\Date($streamer->getCreatedAt()); ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <a href="<?=$this->getUrl(['module' => 'twitchstreams', 'controller' => 'index', 'action' => 'show', 'id' => $streamer->getId()]) ?>">
                <?php if ($streamer->getOnline()): ?>
                <?=$streamer->getTitle() ?>
                <?php else: ?>
                <?=$this->getTrans('offline') ?>
                <?php endif; ?>
            </a>
        </div>
        <div class="panel-body">
            <div  id="show-info">
                <div class="col-md-12 col-lg-4">
                    <a href="<?=$this->getUrl(['module' => 'twitchstreams', 'controller' => 'index', 'action' => 'show', 'id' => $streamer->getId()]) ?>">
                        <?php if ($streamer->getOnline()): ?>
                        <img class="thumbnail" src="<?=$streamer->getPreviewMedium() ?>" title="<?=$streamer->getUser().' '.$this->getTrans('playing').' '.$streamer->getGame() ?>">
                        <?php else: ?>
                        <span class="badge"><?=$this->getTrans('offline') ?></span>
                        <?php endif; ?>
                    </a>
                </div>
                <div class="col-md-12 col-lg-8">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <?=$this->getTrans('streamer') ?>
                            <span class="badge">
                                <a href="<?=$this->getUrl(['module' => 'twitchstreams', 'controller' => 'index', 'action' => 'show', 'id' => $streamer->getId()]) ?>">
                                    <?=$streamer->getUser() ?>
                                </a>
                            </span>
                        </li>
                        <li class="list-group-item">
                            <?=$this->getTrans('game') ?>
                            <span class="badge"><?=$streamer->getGame() ?></span>
                        </li>
                        <li class="list-group-item">
                            <?=$this->getTrans('viewers') ?>
                            <span class="badge"><?=number_format($streamer->getViewers(), 0, '','.') ?></span>
                        </li>
                        <li class="list-group-item">
                            <?=$this->getTrans('onlineSince') ?>
                            <?php if ($streamer->getOnline()): ?>
                            <span class="badge"><?=$date->format("d.m.Y H:i") ?></span>
                            <?php else: ?>
                            <span class="badge"><?=$this->getTrans('offline') ?></span>
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
<?php else: ?>
    <?=$this->getTrans('noStreamer') ?>
<?php endif; ?>
</div>
