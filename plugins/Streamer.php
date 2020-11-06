<?php

namespace Modules\Twitchstreams\Plugins;

use \Modules\Twitchstreams\Models\Streamer as StreamerModel;

class Streamer
{
    private $apiKey = '';
    private $streamer;
    private $onlineStreamer = [];

    function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getOnlineStreamer()
    {
        if ($this->streamer) {
            foreach ($this->streamer as $streamer) {
                $ch = curl_init('https://api.twitch.tv/kraken/search/streams?query=' . $streamer->getUser());
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Accept: application/vnd.twitchtv.v5+json', 'Client-ID: ' . $this->apiKey]);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $data = curl_exec($ch);
                curl_close($ch);
                $allres = json_decode($data);

                foreach ($allres->{'streams'} as $stream) {
                    $model = new StreamerModel();
                    if ($model) {
                        $model->setUser($stream->{'channel'}->{'display_name'})
                            ->setTitle($stream->{'channel'}->{'status'})
                            ->setViewers($stream->{'viewers'})
                            ->setOnline($stream->{'stream_type'} == 'live' ? true : false)
                            ->setPreviewMedium(str_replace('{width}x{height}', '1920x1080', $stream->{'preview'}->{'template'}))
                            ->setCreatedAt($stream->{'channel'}->{'updated_at'});

                        $model->setGame($stream->{'channel'}->{'game'});

                        $this->onlineStreamer[] = $model;
                    }
                }
            }
        }

        return $this->onlineStreamer;
    }

    public function setStreamer($streamer)
    {
        $this->streamer = $streamer;
    }
}
