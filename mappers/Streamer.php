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
            $model->setId($streamerRow['id'])
                ->setUser($streamerRow['user'])
                ->setTitle($streamerRow['title'])
                ->setOnline($streamerRow['online'])
                ->setGame($streamerRow['game'])
                ->setViewers($streamerRow['viewers'])
                ->setPreviewMedium($streamerRow['previewMedium'])
                ->setCreatedAt($streamerRow['createdAt']);
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
            'createdAt' => $model->getCreatedAt(),
        ];

        if ($model->getId()) {
            $return = $this->db()->update('twitchstreams_streamer')
                ->values($fields)
                ->where(['id' => $model->getId()])
                ->execute();
        } else {
            $return = $this->db()->insert('twitchstreams_streamer')
                ->values($fields)
                ->execute();
        }
        return $return;
    }

    public function delete(int $id)
    {
        $this->db()->delete('twitchstreams_streamer')
            ->where(['id' => $id])
            ->execute();
    }

    public function readById(int $id)
    {
        $entrys = $this->getStreamer(['id' => (int) $id]);

        if (!empty($entrys)) {
            return reset($entrys);
        }
        
        return null;
    }

    public function readByUser(string $user)
    {
        $entrys = $this->getStreamer(['user' => $user]);

        if (!empty($entrys)) {
            return reset($entrys);
        }
        
        return null;
    }

    public function updateOnlineStreamer(string $apiKey, StreamerModel $streamer = null)
    {
        $api = new StreamerAPI($apiKey);

        if (!$streamer) {
            $streamerInDatabase = $this->getStreamer();
        } else {
            $streamerInDatabase[] = $streamer;
        }

        if (!$streamerInDatabase){
            return null;
        }

        $api->setStreamer($streamerInDatabase);
        $onlineStreamer = $api->getOnlineStreamer();

        foreach ($streamerInDatabase as $id => $streamer) {
            $streamer->setTitle("")
                ->setOnline(0)
                ->setGame("")
                ->setViewers(0)
                ->setPreviewMedium("");

            foreach ($onlineStreamer as $id => $obj) {
                if (strtolower($streamer->getUser()) == strtolower($obj->getUser())) {
                    $streamer->setUser($obj->getUser());
                    $streamer->setTitle($obj->getTitle())
                        ->setOnline($obj->getOnline())
                        ->setGame($obj->getGame())
                        ->setViewers($obj->getViewers())
                        ->setPreviewMedium($obj->getPreviewMedium())
                        ->setCreatedAt($obj->getCreatedAt());

                    unset($onlineStreamer[$id]);
                    break;
                }
            }

            $streamerInDatabase[$id] = $streamer;

            $this->save($streamer);
        }
        return $streamerInDatabase;
    }
}
