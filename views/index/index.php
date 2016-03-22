<?php $streamer = $this->get('streamer');?>

<?php for($i = 0; $i < sizeof($streamer); $i++) : ?>
<div class="row">
  <?php if(isset($streamer[$i])) : ?>
    <div class="panel panel-default">
      <div class="panel-heading"><?php echo $streamer[$i]->getTitle(); ?></div>
      <div class="panel-body">
        <div class="col-md-4"><a href="<?php echo $streamer[$i]->getLink(); ?>" target="_blank"><img src="<?php echo $streamer[$i]->getPreviewMedium(); ?>" title="<?php echo $streamer[$i]->getUser() . ' playing ' . $streamer[$i]->getGame(); ?>"></a></div>
        <div class="col-md-8">
          <ul class="list-group">
            <li class="list-group-item">
              <span class="badge"><?php echo $streamer[$i]->getUser(); ?></span>
              Streamer
            </li>
            <li class="list-group-item">
              <span class="badge"><?php echo $streamer[$i]->getGame(); ?></span>
              Game
            </li>
            <li class="list-group-item">
              <span class="badge"><?php echo $streamer[$i]->getViewers(); ?></span>
              Viewers
            </li>
            <li class="list-group-item">
              <span class="badge"><?php echo $streamer[$i]->getCreatedAt(); ?></span>
              Created at
            </li>
          </ul>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div><br />
<?php endfor ?>
