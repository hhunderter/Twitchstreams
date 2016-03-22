<?php
namespace Modules\Twitchstreams\Boxes;

use Modules\Twitchstreams\Mappers\Streamer as StreamerMapper;

class Streamer extends \Ilch\Box
{
    public function render()
    {
        $mapper = new StreamerMapper();
        $this->getView()->set('streamer', $mapper->getStreamer(array('online' => 1)));
    }
}
