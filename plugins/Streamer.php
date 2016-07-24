<?php

namespace Modules\Twitchstreams\Plugins;

use \Modules\Twitchstreams\Models\Streamer as StreamerModel;
use \Modules\Twitchstreams\Mappers\Streamer as StreamerMapper;

class Streamer
{
    private $streamer;
    private $onlineStreamer = [];

    public function getOnlineStreamer()
    {
        $mapper = new StreamerMapper();

        $userArray = [];
        foreach ($this->streamer as $streamer) {
            $userArray[] = $streamer->getUser();
        }

        $user = implode(',', $userArray);
        $url = 'https://api.twitch.tv/kraken/streams?channel='.$user;
        $contents = file_get_contents($url);
        $allres = json_decode($contents);

        foreach ($allres->{'streams'} as $stream) {
            $assoc = $mapper->readByUser($stream->{'channel'}->{'display_name'});
            $model = new StreamerModel();
            $model->setId($assoc['id']);
            $model->setUser($assoc['user']);
            $model->setTitle($stream->{'channel'}->{'status'});
            $model->setOnline($assoc['online']);
            $model->setGame($stream->{'game'});
            $model->setViewers($stream->{'viewers'});
            $model->setPreviewMedium($stream->{'preview'}->{'medium'});
            $model->setLink($stream->{'channel'}->{'url'});
            $model->setCreatedAt($stream->{'created_at'});
            $this->onlineStreamer[] = $model;
        }

        return $this->onlineStreamer;
    }

    public function setStreamer($streamer)
    {
        $this->streamer = $streamer;
    }
}
