<form action="" method="post">
    <?=$this->getTokenField(); ?>
    <div class="form-group">
        <label for="inputUser">User</label>
        <input type="text" name="inputUser" value="<?php if($this->get('streamer') != '') { echo $this->escape($this->get('streamer')->getUser()); } ?>" class="form-control" id="inputUser" placeholder="Benutzername eingeben" />
    </div>
    <?php if($this->get('streamer') != '') : ?>
    <?=$this->getSaveBar('edit'); ?>
    <?php else : ?>
    <?=$this->getSaveBar('add'); ?>
    <?php endif; ?>
</form>
