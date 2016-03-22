<form class="form-horizontal" method="POST" action="">
	<?=$this->getTokenField() ?>
	<div class="panel panel-default">
	    <div class="panel-heading">Allgemeine Einstellungen</div>
	    <div class="panel-body">
	        <div class="checkbox">
	            <label>
	            	<?php if($this->get('requestEveryPage') == 1) { ?>
	                	<input name="requestEveryPage" type="checkbox" checked> Streams bei jedem Seitenaufruf aktualisieren?
	            	<?php } else { ?>
	            		<input name="requestEveryPage" type="checkbox"> Streams bei jedem Seitenaufruf aktualisieren?	
	            	<?php } ?>
	            </label>
	        </div>
	    </div>
	</div>
	<?= $this->getSaveBar(); ?>
</form>