<form method="POST" class="form-horizontal" action="">
    <?=$this->getTokenField(); ?>
    <div class="form-group">
        <label for="inputUser"><?=$this->getTrans('streamer') ?></label>
        <input type="text"
               name="inputUser"
               class="form-control"
               id="inputUser"
               placeholder="<?=$this->getTrans('username') ?>"
               value="<?php if ($this->get('streamer') != '') { echo $this->escape($this->get('streamer')->getUser()); } ?>" />
    </div>

    <?php if ($this->get('streamer') != ''): ?>
        <?=$this->getSaveBar('edit'); ?>
    <?php else: ?>
        <?=$this->getSaveBar('add'); ?>
    <?php endif; ?>
</form>
