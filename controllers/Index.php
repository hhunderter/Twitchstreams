<?php
namespace Modules\Twitchstreams\Controllers;

use \Modules\Twitchstreams\Mappers\Streamer as StreamerMapper;

class Index extends \Ilch\Controller\Frontend
{
    
    public function init()
    {
        
    }
    
    public function indexAction()
    {
        $mapper = new StreamerMapper();
        $this->getLayout()->getHmenu()->add($this->getTranslator()->trans('menuStreamer'), array('action' => 'index'));
        $callApi = $this->getConfig()->get('twitchstreams_requestEveryPageCall');
        if($callApi == 1) {
            $this->updateAction();
        }
        if($this->getRequest()->getParam('id')) {
            $this->getLayout()->getHmenu()->add($this->getTranslator()->trans('showStreamer'), array('action' => 'index'));
            $id = $this->getRequest()->getParam('id');
            $this->getView()->set('streamer', $mapper->getStreamer(array('id' => $id, 'online' => 1)));
        } else {
            $this->getView()->set('streamer', $mapper->getStreamer(array('online' => 1)));    
        }
    }
    
    public function updateAction()
    {
        $mapper = new StreamerMapper();
        $mapper->updateOnlineStreamer();
    }
    
}