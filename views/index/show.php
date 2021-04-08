<?php
$streamer = $this->get('streamer')[0];
$date = new \Ilch\Date($streamer->getCreatedAt());
?>

<link href="<?=$this->getModuleUrl('static/css/streams.css') ?>" rel="stylesheet">

<div id="streamer">
    <div class="panel panel-default">
        <div class="panel-heading">
            <?=$streamer->getTitle() ?>
        </div>
        <div class="panel-body">
            <div class="col-md-12 col-lg-4">
                <img class="thumbnail" src="<?=$streamer->getPreviewMedium() ?>" title="<?=$streamer->getUser().' '.$this->getTrans('playing').' '.$streamer->getGame() ?>">
            </div>
            <div class="col-md-12 col-lg-8">
                <ul class="list-group">
                    <li class="list-group-item">
                        <?=$this->getTrans('streamer') ?>
                        <span class="badge">
                            <a href="https://www.twitch.tv/<?=$streamer->getUser() ?>" target="_blank"><?=$streamer->getUser() ?></a>
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
                        <span class="badge"><?=$date->format("d.m.Y H:i") ?></span>
                    </li>
                </ul>
            </div>
            <div class="clearfix"></div>
            <div id="stream-box" style="display: none;">
                <div id="twitch_stream"></div>
            </div>
        </div>
        <div class="panel-footer clearfix">
            <div class="pull-left">
                <button id="stream-popup" class="btn-default btn" href="javascript: void(0)" 
                onclick="window.open('https://player.twitch.tv/?channel=<?=$streamer->getUser() ?>&parent=localhost.net<?=(count($this->get('domains')) > 1 ? '&parent='.implode('&parent=', $this->get('domains')) : '') ?>&muted=true', '', 'width=800, height=450');">
                    <?=$this->getTrans('streamPopUp') ?>
                </button>
                <button id="chat-popup" class="btn-default btn" href="javascript: void(0)" 
                onclick="window.open('https://www.twitch.tv/embed/<?=$streamer->getUser() ?>/chat?parent=localhost.net<?=(count($this->get('domains')) > 1 ? '&parent='.implode('&parent=', $this->get('domains')) : '') ?>', '', 'width=800, height=450');">
                    <?=$this->getTrans('chatPopUp') ?>
                </button>
            </div>
            <div class="pull-right">
                <button id="stream" class="btn-primary btn">
                    <?=$this->getTrans('showStream') ?>
                </button>
            </div>
        </div>
    </div>
</div>

<script src= "https://player.twitch.tv/js/embed/v1.js"></script>
<script type="text/javascript">
$(document).ready(function() {

    var options = {
        width: "100%",
        height: "400px",
        channel: "<?=$streamer->getUser() ?>",
        // only needed if your site is also embedded on embed.example.com and othersite.example.com
        parent: ["localhost.net"<?=(count($this->get('domains')) > 1 ? ', "'.implode('", "', $this->get('domains')).'"' : '') ?>], //"embed.example.com"
        muted: true,
        autoplay: false
    };
    var player = new Twitch.Player("twitch_stream", options);

    $('#stream').click(function() {
        var link = $(this);
        $('#stream-box').slideToggle('slow', function() {
            if ($(this).is(":visible")) {
                link.removeClass('btn-primary').addClass('btn-danger');
                link.text('<?=$this->getTrans('hideStream') ?>');

                player.play();
            } else {
                player.pause();
                if (player.isPaused()) {
                    link.removeClass('btn-danger').addClass('btn-primary');
                    link.text('<?=$this->getTrans('showStream') ?>');
                }
            }
        });
    });

});
</script>
