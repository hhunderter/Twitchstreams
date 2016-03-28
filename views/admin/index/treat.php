<form method="POST" class="form-horizontal" action="">
    <?=$this->getTokenField() ?>
    <div class="form-group">
        <label for="inputUser" class="col-lg-2 control-label">
            <?=$this->getTrans('streamer') ?>
        </label>
        <div class="col-lg-2">
            <input class="form-control"
                   type="text"
                   name="inputUser"
                   placeholder="<?=$this->getTrans('username') ?>"
                   value="<?php if ($this->get('streamer') != '') { echo $this->escape($this->get('streamer')->getUser()); } ?>" />
        </div>
    </div>

    <?php if ($this->get('streamer') != ''): ?>
        <?=$this->getSaveBar('edit'); ?>
    <?php else: ?>
        <?=$this->getSaveBar('add'); ?>
    <?php endif; ?>
</form>
