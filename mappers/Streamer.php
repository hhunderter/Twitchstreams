<?php

namespace Modules\Twitchstreams\Mappers;

use \Modules\Twitchstreams\Models\Streamer as StreamerModel;
use \Modules\Twitchstreams\Plugins\Streamer as StreamerAPI;

class Streamer extends \Ilch\Mapper
{

    public function getStreamer($where = [])
    {
        $resultArray = $this->db()->select('*')
            ->from('twitchstreams_streamer')
            ->where($where)
            ->execute()
            ->fetchRows();

        if (empty($resultArray)) {
            return null;
        }

        $streamer = [];
        foreach ($resultArray as $streamerRow) {
            $model = new StreamerModel();
            $model->setId($streamerRow['id']);
            $model->setUser($streamerRow['user']);
            $model->setTitle($streamerRow['title']);
            $model->setOnline($streamerRow['online']);
            $model->setGame($streamerRow['game']);
            $model->setViewers($streamerRow['viewers']);
            $model->setPreviewMedium($streamerRow['previewMedium']);
            $model->setLink($streamerRow['link']);
            $model->setCreatedAt(date("d.m.y h:i", strtotime($streamerRow['createdAt'])));
            $streamer[] = $model;
        }

        return $streamer;
    }

    public function save(StreamerModel $model)
    {
        $fields = [
            'user' => $model->getUser(),
            'title' => $model->getTitle(),
            'online' => $model->getOnline(),
            'game' => $model->getGame(),
            'viewers' => $model->getViewers(),
            'previewMedium' => $model->getPreviewMedium(),
            'link' => $model->getLink(),
            'createdAt' => $model->getCreatedAt(),
        ];

        if ($model->getId()) {
            $this->db()->update('twitchstreams_streamer')
                ->values($fields)
                ->where(['id' => $model->getId()])
                ->execute();
        } else {
            $this->db()->insert('twitchstreams_streamer')
                ->values($fields)
                ->execute();
        }
    }
    
    public function delete($id)
    {
        $this->db()->delete('twitchstreams_streamer')
            ->where(['id' => $id])
            ->execute();
    }

    public function readById($id)
    {
        $result = $this->db()->select(['id', 'user', 'online', 'game', 'viewers'])
            ->from('twitchstreams_streamer')
            ->where(['id' => $id])
            ->execute();

        return $result->fetchAssoc();
    }
    
    public function readByUser($user)
    {
        $result = $this->db()->select(['id', 'user', 'online', 'game', 'viewers'])
            ->from('twitchstreams_streamer')
            ->where(['user' => $user])
            ->execute();

        return $result->fetchAssoc();
    }
    
    public function updateOnlineStreamer($apiKey)
    {
        $api = new StreamerAPI($apiKey);

        $streamerInDatabase = $this->getStreamer();
        $api->setStreamer($streamerInDatabase);
        $onlineStreamer = $api->getOnlineStreamer();

        foreach ($streamerInDatabase as $streamer) {
            $streamer->setTitle("");
            $streamer->setOnline(0);
            $streamer->setGame("");
            $streamer->setViewers(0);
            $streamer->setPreviewMedium("");
            $streamer->setLink("");

            foreach ($onlineStreamer as $obj) {
                if ($streamer->getId() == $obj->getId()) {
                    $streamer->setTitle($obj->getTitle());
                    $streamer->setOnline(1);
                    $streamer->setGame($obj->getGame());
                    $streamer->setViewers($obj->getViewers());
                    $streamer->setPreviewMedium($obj->getPreviewMedium());
                    $streamer->setLink($obj->getLink());
                    $streamer->setCreatedAt($obj->getCreatedAt());
                    break;
                }
            }

            $this->save($streamer);
        }
    }
}
