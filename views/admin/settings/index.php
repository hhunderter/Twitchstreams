<form class="form-horizontal" method="POST" action="">
    <?=$this->getTokenField() ?>
    <div class="panel panel-default">
        <div class="panel-heading">Allgemeine Einstellungen</div>
        <div class="panel-body">
            <div class="checkbox">
                <label>
                    <input name="requestEveryPage" type="checkbox" <?php if ($this->get('requestEveryPage') == 1) { echo 'checked'; } ?>> Streams bei jedem Seitenaufruf aktualisieren?	
                </label>
            </div>
        </div>
    </div>

    <?= $this->getSaveBar(); ?>
</form>
