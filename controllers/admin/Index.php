<?php
namespace Modules\Twitchstreams\Controllers\Admin;

use \Modules\Twitchstreams\Mappers\Streamer as StreamerMapper;
use \Modules\Twitchstreams\Mappers\Settings as SettingsMapper;
use \Modules\Twitchstreams\Models\Streamer as StreamerModel;

class Index extends \Ilch\Controller\Admin
{
    
    public function init()
    {
        $this->getLayout()->addMenu
        (
            'module',
            array
            (
                array
                (
                    'name' => 'menuStreamer',
                    'active' => true,
                    'icon' => 'fa fa-th-list',
                    'url' => $this->getLayout()->getUrl(array('controller' => 'index', 'action' => 'index'))
                ),
                array
                (
                    'name' => 'menuSettings',
                    'active' => false,
                    'icon' => 'fa fa-cogs',
                    'url' => $this->getLayout()->getUrl(array('controller' => 'settings', 'action' => 'index'))
                )
            )
        );
        
        $this->getLayout()->addMenuAction
        (
            array
            (
                'name' => 'add',
                'icon' => 'fa fa-plus-circle',
                'url' => $this->getLayout()->getUrl(array('controller' => 'index', 'action' => 'treat'))
            )
        );
        
    }
    
    public function indexAction()
    {
        $mapper = new StreamerMapper();
        $this->getLayout()->getAdminHmenu()->add($this->getTranslator()->trans('menuStreamer'), array('action' => 'index'));     
        $this->getView()->set('streamer', $mapper->getStreamer());
    }
    
    public function treatAction()
    {
        $this->getLayout()->getAdminHmenu()->add($this->getTranslator()->trans('menuNewStreamer'), array('action' => 'treat'));
        if($this->getRequest()->getParam('id')) {
            $mapper = new StreamerMapper();
            $id = $this->getRequest()->getParam('id');
            $streamerArray = $mapper->readById($id);
            $streamerModel = new StreamerModel();
            $streamerModel->setId($streamerArray['id']);
            $streamerModel->setUser($streamerArray['user']);
            $streamerModel->setOnline($streamerArray['online']);
            $streamerModel->setGame($streamerArray['game']);
            $this->getView()->set('streamer', $streamerModel);
        }
        if($this->getRequest()->isPost()) {
            $mapper = new StreamerMapper();
            $user = $this->getRequest()->getPost('inputUser');
            $model = new StreamerModel();
            if($this->getRequest()->getParam('id')) {
                $model->setId($this->getRequest()->getParam('id'));
            }
            $model->setUser($user);
            $model->setOnline(0);
            $mapper->save($model);
            $this->redirect(array('action' => 'index'));
        }
    }
    
    public function deleteAction()
    {
        if($this->getRequest()->getParam('id')) {
            $mapper = new StreamerMapper();
            $mapper->delete($this->getRequest()->getParam('id'));
            $this->redirect(array('action' => 'index'));
        }
    }
    
}
