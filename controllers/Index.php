<?php

namespace Modules\Twitchstreams\Controllers;

use \Modules\Twitchstreams\Mappers\Streamer as StreamerMapper;

class Index extends \Ilch\Controller\Frontend
{
    public function indexAction()
    {
        $mapper = new StreamerMapper();
        $streamers = $mapper->getStreamer(($this->getConfig()->get('twitchstreams_showOffline') ? [] : ['online' => 1]));

        $this->getLayout()->getHmenu()
            ->add($this->getTranslator()->trans('menuStreamer'), ['action' => 'index']);

        if ($this->getConfig()->get('twitchstreams_requestEveryPageCall') == 1) {
            $this->updateAction();
        }

        $this->getView()->set('streamer', $streamers);
    }

    public function showAction()
    {
        $mapper = new StreamerMapper();

        $streamer = $mapper->readById($this->getRequest()->getParam('id'));
        if (!$streamer) {
            $this->redirect()
                    ->to(['action' => 'index']);
        }

        $this->getLayout()->getHmenu()
            ->add($this->getTranslator()->trans('menuStreamer'), ['action' => 'index'])
            ->add($streamer->getUser(), ['id' => $this->getRequest()->getParam('id')]);

        if ($this->getConfig()->get('twitchstreams_requestEveryPageCall') == 1) {
            $this->updateAction();
        }

        $this->getView()->set('streamer', $streamer);
        $this->getView()->set('domains', $this->getConfig()->get('twitchstreams_domains') ? explode(',', $this->getConfig()->get('twitchstreams_domains')) : []);
    }

    public function updateAction()
    {
        $mapper = new StreamerMapper();

        $mapper->updateOnlineStreamer((string)$this->getConfig()->get('twitchstreams_apikey'));
    }
}
